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
        EVENT_ON_FAIL = SMSTaskInterface::STATUS_FAIL;

    /** @var SMSTaskInterface */
    private $task;

    public function __construct(SMSTaskInterface $task)
    {
        $this->task = $task;
    }

    /**
     * @return SMSTaskInterface
     */
    public function getTask()
    {
        return $this->task;
    }
} 