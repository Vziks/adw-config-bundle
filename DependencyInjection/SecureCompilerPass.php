<?php

namespace ADW\ConfigBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class SecureCompilerPass.
 * Project ConfigBundle.
 *
 * @author Anton Prokhorov
 */
class SecureCompilerPass implements CompilerPassInterface
{
    /**
     * @var array
     */
    protected $secure;

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $secure = [];

        $securityConfig = $container->getExtensionConfig('security');

        foreach ($securityConfig[0]['firewalls'] as $firewallsName => $firewallsConfig) {
            $secure[$firewallsName] = $firewallsConfig['pattern'];
        }

        $container->getDefinition('adw.event_listener.request_listener')->replaceArgument(0, $secure);
    }
}
