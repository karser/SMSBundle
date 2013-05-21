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
     * @return bool
     */
    public function send(SMSTaskInterface $SMSTask);
}