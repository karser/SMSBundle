<?php
namespace Karser\SMSBundle\Command;

use Karser\SMSBundle\Event\KarserSmsEvent;
use Karser\SMSBundle\Handler\HandlerInterface;
use Karser\SMSBundle\Manager\SMSManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

abstract class BaseCommand extends ContainerAwareCommand
{
    /** @var OutputInterface */
    protected $output;

    /** @var  EventDispatcher */
    private $disp;

    /** @var SMSManager */
    private $sm;

    protected function getSmsManager()
    {
        if (empty($this->sm)) {
            $this->sm = $this->getContainer()->get('karser.sms.manager');
        }
        return $this->sm;
    }

    protected function dispatch($eventName, KarserSmsEvent $event)
    {
        if (empty($this->disp)) {
            $this->disp = $this->getContainer()->get('event_dispatcher');
        }
        $this->disp->dispatch($eventName, $event);
    }

    protected function checkBalance(HandlerInterface $handler)
    {
        $balance = $handler->getBalance();
        $this->writeBalance($balance);

        if ($balance < 50) {
            $ev = new KarserSmsEvent();
            $ev->setBalance($balance);
            $ev->setHandler($handler->getName());
            $this->dispatch(KarserSmsEvent::EVENT_ON_BALANCE, $ev);
        }

        if ($balance < 5) {
            throw new \LogicException('Balance error');
        }
    }
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
