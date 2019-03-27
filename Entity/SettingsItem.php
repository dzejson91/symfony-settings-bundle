<?php
/**
 * @author Krystian Jasnos <dzejson91@gmail.com>
 */

namespace JasonMx\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Class SettingsItem
 * @package JasonMx\SettingsBundle\Entity
 *
 * @ORM\Entity(repositoryClass="JasonMx\SettingsBundle\Repository\SettingsRepository")
 * @ORM\Table(name="settings", uniqueConstraints={
            @ORM\UniqueConstraint(name="key", columns={"key", "locale"})
 *     })
 */
class SettingsItem
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
     * @var SettingsGroup
     * @ORM\ManyToOne(targetEntity="JasonMx\SettingsBundle\Entity\SettingsGroup", inversedBy="settings", cascade={"persist"})
     */
    protected $group;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $locale;

    /**
     * @var string
     * @ORM\Column(type="string", name="`key`")
     */
    protected $key;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $value;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $type;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return SettingsGroup
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param SettingsGroup $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
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
     * @return string
     */
    public function getValue()
    {
        switch ($this->type){
            case 'int':
            case 'integer':
                return (int)$this->value;

            case 'bool':
            case 'boolean':
            case 'checkbox':
                return (bool)($this->value);

            case 'float': return (float)($this->value);
        }

        return $this->value;
    }

    /**
     * @param string $value
     * @return SettingsItem
     */
    public function setValue($value)
    {
        switch ($this->type)
        {
            case 'password': {
                if(is_null($value) || !strlen($value)) break;
                $this->value = $value; break;
            }

            case 'int':
            case 'integer':
                $this->value = (int)($value); break;

            case 'bool':
            case 'boolean':
            case 'checkbox':
                $this->value = (int)($value); break;

            default: $this->value = $value;
        }

        return $this;
    }


    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
}