<?php
namespace Karser\SMSBundle\Command;

use Karser\SMSBundle\Entity\SMSTaskInterface;
use Karser\SMSBundle\Handler\HandlerInterface;
use Karser\SMSBundle\Manager\SMSManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendSmsCommand extends BaseCommand
{
    /** @var SMSManager */
    private $SMSManager;

    /** @var HandlerInterface */
    private $handler;

    protected function configure()
    {
        $this->setName('sms:send');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->SMSManager = $this->getContainer()->get('karser.sms.manager');
        $this->handler = $this->SMSManager->getDefaultHandler();

        $this->output = $output;

        $this->checkBalance();
        $this->sendMessages();

        $this->output->writeln('Done.');
    }

    private function checkBalance()
    {
        $balance = $this->handler->getBalance();
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

        foreach ($tasks as $SmsTask)
        {
            try {
                if ($SmsTask->isValid()) {
                    $msg_id = $this->handler->send($SmsTask);
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
                $this->checkBalance();
                continue;
            }
        }

        /** @var SMSTaskInterface[] $tasks */
        $tasks = $SmsTaskRepository->findBy(['status' => SMSTaskInterface::STATUS_PROCESSING]);
        $this->writelnFormatted(sprintf('Messages to check %d', count($tasks)));
        foreach ($tasks as $SmsTask)
        {
            try {
                if ($SmsTask->isValid()) {
                    $status = $this->handler->checkStatus($SmsTask->getMessageId());
                } else {
                    $status = SMSTaskInterface::STATUS_FAIL;
                }
                $SmsTask->setStatus($status);
                $em->persist($SmsTask);
                $em->flush();
            } catch (\Exception $e) {
                continue;
            }
        }

        $this->output->writeln('');
    }
}
