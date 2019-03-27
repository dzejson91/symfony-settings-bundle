<?php
/**
 * @author Krystian Jasnos <dzejson91@gmail.com>
 */

namespace JasonMx\SettingsBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use JasonMx\SettingsBundle\Entity\SettingsItem;
use JasonMx\SettingsBundle\Repository\SettingsRepository;

class SettingsService
{
    /** @var EntityManager */
    protected $em;

    /** @var SettingsRepository */
    protected $settingRepo;

    /** @var string */
    protected $locale;

    /** @var array */
    protected $settings = array();

    /** @var array */
    protected $settingsGroups = array();

    /**
     * SettingsService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->settingRepo = $em->getRepository(SettingsItem::class);
    }

    /**
     * @param $locale
     */
    public function setLocale($locale){
        $this->locale = $locale;
    }

    /**
     * @param $key
     * @param null $default
     * @param null $locale
     * @return string|null
     */
    public function getValue($key, $default = null, $locale = null){
        $locale = is_null($locale) ? $this->locale : $locale;
        $this->loadSettings($locale);

        /** @var ArrayCollection|SettingsItem[] $settings */
        $settings = &$this->settings[$locale];
        if($settings->containsKey($key)){
            return $settings[$key]->getValue();
        }
        return $default;
    }

    /**
     * @param null $locale
     * @return array|string
     */
    public function getValues($locale = null){
        $locale = is_null($locale) ? $this->locale : $locale;
        $this->loadSettings($locale);

        /** @var ArrayCollection|SettingsItem[] $settings */
        $settings = &$this->settings[$locale];
        $results = array();
        foreach($settings as $setting){
            $results[$setting->getKey()] = $setting->getValue();
        }
        return $results;
    }

    /**
     * @param null $locale
     */
    protected function loadSettings($locale = null){
        if(!array_key_exists($locale, $this->settings)){
            $this->settings[$locale] = $this->settingRepo->loadSettings($locale);
        }
    }

    /**
     * @param $groupName
     * @param null $locale
     * @return array
     */
    public function getGroupValues($groupName, $locale = null){
        $locale = is_null($locale) ? $this->locale : $locale;
        $settings = $this->settingRepo->loadSettings($locale, $groupName);
        $results = array();
        foreach($settings as $setting){
            $results[$setting->getKey()] = $setting->getValue();
        }
        return $results;

    }
}