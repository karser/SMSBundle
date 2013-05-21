<?php
namespace Karser\SMSBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Karser\SMSBundle\Entity\SMSTaskInterface;
use Karser\SMSBundle\Handler\HandlerInterface;

class SMSManager
{
    /** @var  HandlerInterface[] */
    private $handlers;

    /** @var  string */
    private $sms_task_class;

    public function __construct(ObjectManager $em, $sms_task_class = '')
    {
        $this->em = $em;
        $this->sms_task_class = $sms_task_class;
    }

    public function addHandler($id, HandlerInterface $handler)
    {
        $this->handlers[$id] = $handler;
    }

    public function findHandler($phone_number)
    {
        foreach($this->handlers as $handler) {
            if ($handler->supports($phone_number)) {
                return $phone_number;
            }
        }
        return false;
    }

    public function getDefaultHandler()
    {
        return current($this->handlers);
    }

    public function send(SMSTaskInterface $SmsTask)
    {
        $handler = $this->getDefaultHandler();
        if ($handler instanceof HandlerInterface) {
            return $handler->send($SmsTask);
        }
        return false;
    }
}
