<?php
/**
 * @author Krystian Jasnos <dzejson91@gmail.com>
 */

namespace JasonMx\SettingsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SettingsGroup
 * @package JasonMx\SettingsBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="settings_groups")
 */
class SettingsGroup
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @var ArrayCollection|SettingsItem
     * @ORM\OneToMany(targetEntity="JasonMx\SettingsBundle\Entity\SettingsItem", mappedBy="group", cascade={"persist"})
     */
    protected $settings;

    /**
     * SettingsGroup constructor.
     */
    public function __construct()
    {
        $this->settings = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return ArrayCollection|SettingsItem
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param ArrayCollection|SettingsItem $settings
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param SettingsItem $settingsItem
     * @return SettingsGroup
     */
    public function addSetting(SettingsItem $settingsItem)
    {
        if(!$this->settings->contains($settingsItem)){
            $this->settings->add($settingsItem);
        }

        return $this;
    }

    /**
     * @param SettingsItem $settingsItem
     * @return SettingsGroup
     */
    public function removeSetting(SettingsItem $settingsItem)
    {
        if($this->settings->contains($settingsItem)){
            $this->settings->removeElement($settingsItem);
        }

        return $this;
    }
}