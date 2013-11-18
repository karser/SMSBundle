<?php
namespace Karser\SMSBundle\Handler;

use Karser\SMSBundle\Entity\OpsosRangeInterface;
use Karser\SMSBundle\Entity\SMSTaskInterface;

interface HandlerInterface
{
    /**
     * @return string
     */
    public function getName();

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