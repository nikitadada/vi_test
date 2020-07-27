<?php

namespace App;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Bridge\ProxyManager\LazyProxy\Instantiator\RuntimeInstantiator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\CompilerPass\RoutingCompilerPass;

class Container extends ContainerBuilder {

    public static function buildContainer($rootPath)
    {
        $container = new self();
        $container->addCompilerPass(new RoutingCompilerPass());
        $container->setProxyInstantiator(new RuntimeInstantiator());
        $container->setParameter('app_root', $rootPath);

        $loader = new YamlFileLoader($container, new FileLocator(sprintf('%s/config', $rootPath)));
        $loader->load('services.yaml');

        $container->compile();

        return $container;
    }

    public function get($id, $invalidBehavior = ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)
    {
        if (strtolower($id) === 'service_container') {
            if (ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE !== $invalidBehavior) {
                return null;
            }
            throw new InvalidArgumentException(sprintf('The service definition "%s" does not exist.', $id));
        }

        return parent::get($id, $invalidBehavior);
    }
}
