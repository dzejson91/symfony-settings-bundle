<?php
/**
 * @author Krystian Jasnos <dzejson91@gmail.com>
 */

namespace JasonMx\SettingsBundle\DependencyInjection;

use JasonMx\SettingsBundle\Service\SettingsService;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

class SettingsExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $container
            ->setDefinition('settings.service', new Definition(
                SettingsService::class,
                array(
                    new Reference('doctrine.orm.default_entity_manager'),
                )
            ));

        $container
            ->setDefinition('settings.twig_ext', new Definition(
                TwigExtension::class,
                array(
                    new Reference('settings.service'),
                )
            ))
            ->addTag('twig.extension');
    }
}