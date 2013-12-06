<?php
namespace Karser\SMSBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BalanceSmsCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('sms:balance');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $sm = $this->getSmsManager();
        $handler = $sm->getDefaultHandler();
        $this->checkBalance($handler);
        $this->output->writeln('Done.');
    }

} 