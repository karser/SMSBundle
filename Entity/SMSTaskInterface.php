<?php
namespace Karser\SMSBundle\Entity;

interface SMSTaskInterface
{
    const
        STATUS_PENDING = 'pending',
        STATUS_SENT = 'sent',
        STATUS_PROCESSING = 'processing',
        STATUS_FAIL = 'fail';

    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return SmsTask
     */
    public function setPhoneNumber($phoneNumber);

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber();

    /**
     * Set message
     *
     * @param string $message
     * @return SmsTask
     */
    public function setMessage($message);

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage();

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return SmsTask
     */
    public function setCreatedAt($createdAt);

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Set sender
     *
     * @param string $sender
     * @return SmsTask
     */
    public function setSender($sender);

    /**
     * Get sender
     *
     * @return string
     */
    public function getSender();

    /**
     * Set isSent
     *
     * @param boolean $isSent
     * @return SmsTask
     */
    public function setIsSent($isSent);

    /**
     * Get isSent
     *
     * @return boolean
     */
    public function getIsSent();


    /**
     * @param string $status
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getStatus();
}