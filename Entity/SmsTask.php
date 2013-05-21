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
     * @ORM\Column(type="string", length=20)
     *
     * @var string
     */
    protected $status;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $isSent = false;

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
     * Set isSent
     *
     * @param boolean $isSent
     * @return SmsTask
     */
    public function setIsSent($isSent)
    {
        $this->isSent = $isSent;
    
        return $this;
    }

    /**
     * Get isSent
     *
     * @return boolean 
     */
    public function getIsSent()
    {
        return $this->isSent;
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
}