<?php
namespace Karser\SMSBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddSMSHandlers implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('karser.sms.manager')) {
            return;
        }
        $processor = $container->findDefinition('karser.sms.manager');
        foreach ($container->findTaggedServiceIds('sms.handler') as $id => $attr) {
            $processor->addMethodCall('addHandler', array($id, new Reference($id)));
        }
    }
}