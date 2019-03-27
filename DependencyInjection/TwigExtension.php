<?php
/**
 * @author Krystian Jasnos <dzejson91@gmail.com>
 */

namespace JasonMx\SettingsBundle\DependencyInjection;


use JasonMx\SettingsBundle\Service\SettingsService;

class TwigExtension extends \Twig_Extension
{
    /** @var SettingsService $settingsService */
    protected $settingsService;

    /**
     * TwigExtension constructor.
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * @return array|\Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('setting', array($this->settingsService, 'getValue')),
            new \Twig_SimpleFunction('settings', array($this->settingsService, 'getValues')),
            new \Twig_SimpleFunction('settings_group', array($this->settingsService, 'getGroupValues')),
        );
    }
}