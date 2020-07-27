<?php declare(strict_types=1);

namespace App\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RoutingCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $routeTags = $container->findTaggedServiceIds('route');

        $collectionTags = $container->findTaggedServiceIds('route_collection');

        $routeCollections = array();
        foreach ($collectionTags as $serviceName => $tagData) {
            $routeCollections[] = $container->getDefinition($serviceName);
        }

        foreach ($routeTags as $routeServiceName => $tagData) {
            $routeNames = [];
            foreach ($tagData as $tag) {
                if (isset($tag['route_name'])) {
                    $routeNames[] = $tag['route_name'];
                }
            }

            if (!$routeNames) {
                continue;
            }

            $routeReference = new Reference($routeServiceName);
            foreach ($routeCollections as $collection) {
                foreach ($routeNames as $name) {
                    $collection->addMethodCall('add', [$name, $routeReference]);
                }
            }
        }
    }
}
