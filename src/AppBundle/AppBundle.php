<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use AppBundle\DependencyInjection\Compiler\StateHandlerSessionPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class AppBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new StateHandlerSessionPass());
    }
}
