<?php
namespace Karser\SMSBundle\Command;

use Karser\SMSBundle\Entity\SMSTaskInterface;
use Karser\SMSBundle\Event\KarserSmsEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendSmsCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('sms:send');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $this->writelnFormatted('Sending messages...');

        $this->sendMessages();

        $this->output->writeln('Done.');
    }

    private function sendMessages()
    {
        $em = $this->getDoctrineMananger();
        $sms_task_class = $this->getContainer()->getParameter('karser.sms.entity.sms_task.class');
        /** @var \Doctrine\ORM\EntityRepository $SmsTaskRepository */
        $SmsTaskRepository = $em->getRepository($sms_task_class);

        $SMSManager = $this->getSmsManager();

        for ($i = 0; $i < 50; $i++) {
            /** @var SMSTaskInterface $task */
            $task = $SmsTaskRepository->findOneBy(['status' => SMSTaskInterface::STATUS_PENDING]);
            if (empty($task)) {
                break;
            }
            $handler = $SMSManager->getHandler($task->getHandler());
            try {
                if ($handler && $task->isValid()) {
                    $msg_id = $handler->send($task);
                    $task->setMessageId($msg_id);
                    $task->setStatus(SMSTaskInterface::STATUS_PROCESSING);
                    $this->output->write('.');
                } else {
                    throw new \Exception();
                }
            } catch (\Exception $e) {
                $this->output->write('F');
                $this->checkBalance($handler);
                $task->setStatus(SMSTaskInterface::STATUS_FAIL);
            }
            $em->persist($task);
            $em->flush();

            $ev = new KarserSmsEvent();
            $ev->setTask($task);
            $this->dispatch($task->getStatus(), $ev);
        }

        $this->output->writeln('');
    }
}
