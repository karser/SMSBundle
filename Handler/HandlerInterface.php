<?php
namespace Karser\SMSBundle\Handler;

use Karser\SMSBundle\Entity\SMSTaskInterface;

interface HandlerInterface
{
    /**
     * @param string $number
     * @return bool
     */
    public function supports($number);

    /**
     * @return float
     */
    public function getBalance();

    /**
     * @param SMSTaskInterface $SMSTask
     * @return string
     */
    public function send(SMSTaskInterface $SMSTask);

    /**
     * @param string
     * @return string
     */
    public function checkStatus($message_id);
}