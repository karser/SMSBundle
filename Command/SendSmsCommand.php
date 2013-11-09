<?php
namespace Karser\SMSBundle\Command;

use Karser\SMSBundle\Entity\SMSTaskInterface;
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

        $this->sendMessages();

        $this->output->writeln('Done.');
    }

    private function checkBalance(HandlerInterface $handler)
    {
        $balance = $handler->getBalance();
        $this->writeBalance($balance);
        if ($balance < 1) {
            throw new \LogicException('Balance error');
        }
    }

    private function sendMessages()
    {
        $em = $this->getDoctrineMananger();
        $sms_task_class = $this->getContainer()->getParameter('karser.sms.entity.sms_task.class');
        /** @var \Doctrine\ORM\EntityRepository $SmsTaskRepository */
        $SmsTaskRepository = $em->getRepository($sms_task_class);

        /** @var SMSTaskInterface[] $tasks */
        $tasks = $SmsTaskRepository->findBy(['status' => SMSTaskInterface::STATUS_PENDING]);
        $this->writelnFormatted(sprintf('Messages to send %d', count($tasks)));

        $SMSManager = $this->getContainer()->get('karser.sms.manager');

        foreach ($tasks as $SmsTask)
        {
            $handler = $SMSManager->getHandler($SmsTask->getHandler());
            try {
                if ($SmsTask->isValid()) {
                    $msg_id = $handler->send($SmsTask);
                    $SmsTask->setMessageId($msg_id);
                    $SmsTask->setStatus(SMSTaskInterface::STATUS_PROCESSING);
                } else {
                    $SmsTask->setStatus(SMSTaskInterface::STATUS_FAIL);
                }
                $em->persist($SmsTask);
                $em->flush();
                $this->output->write('.');
            } catch (\Exception $e) {
                $this->output->write('F');
                $this->checkBalance($handler);
                continue;
            }
        }

        $this->output->writeln('');
    }
}
