<?php
namespace Karser\SMSBundle\Event;

use Karser\SMSBundle\Entity\SMSTaskInterface;
use Symfony\Component\EventDispatcher\Event;

class KarserSmsEvent extends Event
{
    const
        EVENT_ON_SCHEDULE = SMSTaskInterface::STATUS_PENDING,
        EVENT_ON_PROCESS = SMSTaskInterface::STATUS_PROCESSING,
        EVENT_ON_SEND = SMSTaskInterface::STATUS_SENT,
        EVENT_ON_FAIL = SMSTaskInterface::STATUS_FAIL,
        EVENT_ON_BALANCE = 'balance';

    /** @var SMSTaskInterface */
    private $task;

    /** @var float */
    private $balance;

    /** @var string */
    private $handler;

    /**
     * @return SMSTaskInterface
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @param float $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    /**
     * @return int
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param string $handler
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;
    }

    /**
     * @return string
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @param SMSTaskInterface $task
     */
    public function setTask($task)
    {
        $this->task = $task;
    }
}