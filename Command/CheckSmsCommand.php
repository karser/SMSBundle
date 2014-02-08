<?php
namespace Karser\SMSBundle\Command;

use Karser\SMSBundle\Entity\SMSTaskInterface;
use Karser\SMSBundle\Event\KarserSmsEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckSmsCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('sms:check');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $this->checkMessages();

        $this->output->writeln('Done.');
    }

    private function checkMessages()
    {
        $em = $this->getDoctrineMananger();
        $sms_task_class = $this->getContainer()->getParameter('karser.sms.entity.sms_task.class');
        /** @var \Doctrine\ORM\EntityRepository $SmsTaskRepository */
        $SmsTaskRepository = $em->getRepository($sms_task_class);

        /** @var SMSTaskInterface[] $tasks */
        $tasks = $SmsTaskRepository->findBy(['status' => SMSTaskInterface::STATUS_PROCESSING]);
        $this->writelnFormatted(sprintf('Messages to check %d', count($tasks)));

        $SMSManager = $this->getSmsManager();
        foreach ($tasks as $task)
        {
            $handler = $SMSManager->getHandler($task->getHandler());
            try {
                if ($handler && $task->isValid()) {
                    $status = $handler->checkStatus($task->getMessageId(), $task->getPhoneNumber());
                } else {
                    $status = SMSTaskInterface::STATUS_FAIL;
                }
                $task->setStatus($status);
                $em->persist($task);
                $em->flush();
                $this->dispatch($task->getStatus(), new KarserSmsEvent($task));
            } catch (\Exception $e) {
                continue;
            }
        }

        $this->output->writeln('');
    }
} 