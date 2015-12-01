<?php
/**
 * Copyright 2015 SURFnet B.V.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace AppBundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
class StateHandlerSessionPass implements CompilerPassInterface
{
    /**
     * This is required to ensure that our NamespacedAttributeBag is registered in the session handler
     * before the session is started.
     */
    public function process(ContainerBuilder $container)
    {
        $container
            ->getDefinition('session')
            ->addMethodCall('registerBag', [new Reference('app.session.namespaced_attribute_bag')]);
    }
}