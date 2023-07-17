<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\SocialBundle\DependencyInjection;

use Evrinoma\SocialBundle\EvrinomaSocialBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(EvrinomaSocialBundle::BUNDLE);
        $rootNode = $treeBuilder->getRootNode();
        $supportedDrivers = ['orm'];

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('db_driver')
            ->validate()
            ->ifNotInArray($supportedDrivers)
            ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
            ->end()
            ->cannotBeOverwritten()
            ->defaultValue('orm')
            ->end()
            ->scalarNode('factory')->cannotBeEmpty()->defaultValue(EvrinomaSocialExtension::ENTITY_FACTORY_SOCIAL)->end()
            ->scalarNode('entity')->cannotBeEmpty()->defaultValue(EvrinomaSocialExtension::ENTITY_BASE_SOCIAL)->end()
            ->scalarNode('constraints')->defaultTrue()->info('This option is used to enable/disable basic social constraints')->end()
            ->scalarNode('dto')->cannotBeEmpty()->defaultValue(EvrinomaSocialExtension::DTO_BASE_SOCIAL)->info('This option is used to dto class override')->end()
            ->arrayNode('decorates')->addDefaultsIfNotSet()->children()
            ->scalarNode('command')->defaultNull()->info('This option is used to command social decoration')->end()
            ->scalarNode('query')->defaultNull()->info('This option is used to query social decoration')->end()
            ->end()->end()
            ->arrayNode('serializer')->addDefaultsIfNotSet()->children()
            ->scalarNode('enabled')->defaultTrue()->info('This option is used to enable/disable basic video_content serializers')->end()
            ->scalarNode('path')->cannotBeEmpty()->defaultValue(getcwd())->end()
            ->end()->end()
            ->arrayNode('services')->addDefaultsIfNotSet()->children()
            ->scalarNode('pre_validator')->defaultNull()->info('This option is used to pre_validator overriding')->end()
            ->scalarNode('handler')->cannotBeEmpty()->defaultValue(EvrinomaSocialExtension::HANDLER)->info('This option is used to handler override')->end()
            ->end()->end()
            ->end();

        return $treeBuilder;
    }
}
