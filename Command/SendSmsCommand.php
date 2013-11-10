<?php
namespace Karser\SMSBundle\Command;

use Karser\SMSBundle\Entity\SMSTaskInterface;
use Karser\SMSBundle\Event\KarserSmsEvent;
use Karser\SMSBundle\Handler\HandlerInterface;
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

    private function checkBalance(HandlerInterface $handler)
    {
        $balance = $handler->getBalance();
        $this->writeBalance($balance);
        if ($balance < 5) {
            throw new \LogicException('Balance error');
        }
    }

    private function sendMessages()
    {
        $disp = $this->getContainer()->get('event_dispatcher');
        $em = $this->getDoctrineMananger();
        $sms_task_class = $this->getContainer()->getParameter('karser.sms.entity.sms_task.class');
        /** @var \Doctrine\ORM\EntityRepository $SmsTaskRepository */
        $SmsTaskRepository = $em->getRepository($sms_task_class);

        $SMSManager = $this->getContainer()->get('karser.sms.manager');

        while (true) {
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
            $disp->dispatch($task->getStatus(), new KarserSmsEvent($task));
            $this->output->write('.');
        }

        $this->output->writeln('');
    }
}
