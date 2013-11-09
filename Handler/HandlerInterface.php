<?php
namespace Karser\SMSBundle\Handler;

use Karser\SMSBundle\Entity\HlrInterface;
use Karser\SMSBundle\Entity\SMSTaskInterface;

interface HandlerInterface
{

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $number
     * @param HlrInterface $hlr
     * @return mixed
     */
    public function supports($number, HlrInterface $hlr = null);

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

    /**
     * @return float
     */
    public function getCost();
}