<?php
namespace Karser\SMSBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Karser\SMSBundle\Entity\SMSTaskInterface;
use Karser\SMSBundle\Handler\HandlerInterface;

class SMSManager
{
    /** @var HandlerInterface[] */
    private $handlers = [];

    /** @var string */
    private $sms_task_class;

    /** @var string */
    private $default_handler;

    /** @var ObjectManager */
    private $em;

    public function __construct(ObjectManager $em, $sms_task_class, $default_handler)
    {
        $this->em = $em;
        $this->sms_task_class = $sms_task_class;
        $this->default_handler = $default_handler;
    }

    public function addHandler($id, HandlerInterface $handler)
    {
        $this->handlers[$id] = $handler;
    }

    public function getDefaultHandler()
    {
        return $this->handlers[$this->default_handler];
    }

    /**
     * @param string $code
     * @return HandlerInterface
     */
    public function getHandler($code)
    {
        foreach ($this->handlers as $handler) {
            if ($handler->getName() === $code) {
                return $handler;
            }
        }
        return null;
    }

    /**
     * @return HandlerInterface[]
     */
    public function getHandlers()
    {
        return $this->handlers;
    }
}
