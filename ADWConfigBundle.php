<?php

namespace ADW\ConfigBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use ADW\ConfigBundle\DependencyInjection\SecureCompilerPass;

/**
 * Class ADWConfigBundle.
 * Project ConfigBundle.
 *
 * @author Anton Prokhorov
 */
class ADWConfigBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        // call parent
        parent::build($container);

        // run extra compilerPass
        $container->addCompilerPass(new SecureCompilerPass());
    }
}
