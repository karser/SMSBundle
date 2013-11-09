<?php
namespace Karser\SMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 */
abstract class SmsTask implements SMSTaskInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=20)
     *
     * @var string
     */
    protected $phoneNumber;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @var string
     */
    protected $message_id;

    /**
     * @ORM\Column(type="string", length=1000)
     *
     * @var string
     */
    protected $message;

    /**
     * @ORM\Column(type="string", length=20)
     *
     * @var string
     */
    protected $sender;

    /**
     * @ORM\Column(type="string", length=50)
     *
     * @var string
     */
    protected $handler;

    /**
     * @ORM\Column(type="string", length=20)
     *
     * @var string
     */
    protected $status;

    public function isMessageEmpty()
    {
        return empty($this->message);
    }

    public function isValid()
    {
        return !$this->isMessageEmpty();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return SmsTask
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    
        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return SmsTask
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set sender
     *
     * @param string $sender
     * @return SmsTask
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    
        return $this;
    }

    /**
     * Get sender
     *
     * @return string 
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $message_id
     */
    public function setMessageId($message_id)
    {
        $this->message_id = $message_id;
    }

    /**
     * @return string
     */
    public function getMessageId()
    {
        return $this->message_id;
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
}