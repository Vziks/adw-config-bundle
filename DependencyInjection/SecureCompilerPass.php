<?php

namespace ADW\ConfigBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class SecureCompilerPass.
 * Project proplan.
 * @author Anton Prokhorov
 */
class SecureCompilerPass implements CompilerPassInterface
{
    /**
     * @var array $secure
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

        $container->getDefinition('adw.listener.configrequestresponse')->replaceArgument(0, $secure);

    }
}