<?php
namespace Karser\SMSBundle\Handler;

abstract class AbstractHandler implements HandlerInterface
{
    /** @var string */
    protected $name;

    public function getName()
    {
        return $this->name;
    }
}