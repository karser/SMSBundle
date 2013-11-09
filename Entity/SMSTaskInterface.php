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
     * @return bool
     */
    public function isMessageEmpty();

    /**
     * @return bool
     */
    public function isValid();

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
     * @param string $status
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param string $message_id
     */
    public function setMessageId($message_id);

    /**
     * @return string
     */
    public function getMessageId();

    /**
     * @return string
     */
    public function getHandler();
}