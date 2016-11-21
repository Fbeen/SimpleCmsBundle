<?php

namespace Fbeen\SimpleCmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Menuitem
 *
 * @ORM\Table(name="menuitem")
 * @ORM\Entity
 */
class Menuitem
{
   use ORMBehaviors\Translatable\Translatable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=8)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * CSS class for the <a> element
     * 
     * @var string
     *
     * @ORM\Column(name="a_class", type="string", length=128, nullable=true)
     */
    private $aClass;

    /**
     * CSS class for the <li> element
     * 
     * @var string
     *
     * @ORM\Column(name="li_class", type="string", length=64, nullable=true)
     */
    private $liClass;

    /**
     * @var integer
     *
     * @ORM\Column(name="sort", type="integer")
     */
    private $sort = 999;

    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="menuitems")
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $menu;
    
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Menu
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return Menuitem
     */
    public function setLabel($label, $locale = null)
    {
        $this->translate($locale)->setLabel($label);

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel($locale = null)
    {
        return $this->translate($locale)->getLabel();
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Menuitem
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set menu
     *
     * @param \Fbeen\SimpleCmsBundle\Entity\Menu $menu
     *
     * @return Menuitem
     */
    public function setMenu(\Fbeen\SimpleCmsBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \Fbeen\SimpleCmsBundle\Entity\Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return Menuitem
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return integer
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set aClass
     *
     * @param string $aClass
     *
     * @return Menuitem
     */
    public function setAClass($aClass)
    {
        $this->aClass = $aClass;

        return $this;
    }

    /**
     * Get aClass
     *
     * @return string
     */
    public function getAClass()
    {
        return $this->aClass;
    }

    /**
     * Set liClass
     *
     * @param string $liClass
     *
     * @return Menuitem
     */
    public function setLiClass($liClass)
    {
        $this->liClass = $liClass;

        return $this;
    }

    /**
     * Get liClass
     *
     * @return string
     */
    public function getLiClass()
    {
        return $this->liClass;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Menuitem
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
