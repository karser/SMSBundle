<?php
namespace Karser\SMSBundle\Handler;

use Karser\SMSBundle\Entity\HlrInterface;

abstract class AbstractHandler implements HandlerInterface
{
    /** @var string */
    protected $name;

    /** @var float */
    protected $cost;

    public function getCost()
    {
        return $this->cost;
    }

    public function getName()
    {
        return $this->name;
    }

    public function supports($number, HlrInterface $hlr = null)
    {
        return true;
    }
}