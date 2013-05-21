<?php
namespace Karser\SMSBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Karser\MainSMSBundle\Model\MainSMS;

abstract class BaseCommand extends ContainerAwareCommand
{
    /** @var OutputInterface */
    protected $output;

    protected function getDoctrineMananger()
    {
        /** @var \Doctrine\Common\Persistence\ManagerRegistry $doctrine */
        $doctrine = $this->getContainer()->get('doctrine');
        return $doctrine->getManager();
    }

    protected function writelnFormatted($message)
    {
        $this->output->writeln(sprintf('<comment>></comment> <info>%s</info>', $message));
    }

    protected function writeBalance($balance)
    {
        $this->writelnFormatted(sprintf('Balance is %.2f', $balance));
    }
}
