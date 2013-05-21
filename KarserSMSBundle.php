<?php

namespace Karser\SMSBundle;

use Karser\SMSBundle\DependencyInjection\Compiler\AddSMSHandlers;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KarserSMSBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new AddSMSHandlers());
    }
}
