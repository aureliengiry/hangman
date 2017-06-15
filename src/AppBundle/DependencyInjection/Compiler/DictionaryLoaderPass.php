<?php

namespace AppBundle\DependencyInjection\Compiler;

use AppBundle\Game\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DictionaryLoaderPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('app.game.word_list')) {
            return;
        }

        $wordList = $container->findDefinition('app.game.word_list');
        $loaders = $container->findTaggedServiceIds('app.game.dictionary_loader');

        if (!$loaders) {
            throw new \LogicException(sprintf('Please register some "%s" instances for "app.game.word_list".', LoaderInterface::class));
        }

        foreach ($loaders as $serviceId => $params) {
            if (empty($params[0]['loader_type'])) {
                throw new \LogicException(sprintf('Please add a "loader_type" to the tag "app.game.dictionary_loader" on service "%s".', $serviceId));
            }

            $wordList->addMethodCall('addLoader', [$params[0]['loader_type'], new Reference($serviceId)]);
        }

        $wordList->addMethodCall('loadDictionaries', [$container->getParameter('app.game.dictionaries')]);
    }
}
