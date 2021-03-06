<?php

namespace Fbeen\SimpleCmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Menu
 *
 * @ORM\Table(name="menu")
 * @ORM\Entity(repositoryClass="Fbeen\SimpleCmsBundle\Repository\MenuRepository")
 */
class Menu
{
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
     * @ORM\Column(name="name", type="string", length=64, unique=true)
     */
    private $name;

    /**
     * CSS class for the <ul> element
     * 
     * @var string
     *
     * @ORM\Column(name="class", type="string", length=128, nullable=true)
     */
    private $class;

    /**
     * @ORM\OneToMany(targetEntity="Menuitem", mappedBy="menu", cascade={"persist"}, orphanRemoval=true)
     * 
     * @ORM\OrderBy({"sort" = "ASC"})
     */
    private $menuitems;


    public function __construct() {
        $this->menuitems = new ArrayCollection();
    }

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
     * Add menuitem
     *
     * @param \Fbeen\SimpleCmsBundle\Entity\Menuitem $menuitem
     *
     * @return Menu
     */
    public function addMenuitem(\Fbeen\SimpleCmsBundle\Entity\Menuitem $menuitem)
    {
        $this->menuitems[] = $menuitem;

        return $this;
    }

    /**
     * Remove menuitem
     *
     * @param \Fbeen\SimpleCmsBundle\Entity\Menuitem $menuitem
     */
    public function removeMenuitem(\Fbeen\SimpleCmsBundle\Entity\Menuitem $menuitem)
    {
        $this->menuitems->removeElement($menuitem);
    }

    /**
     * Get menuitems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenuitems()
    {
        return $this->menuitems;
    }

    /**
     * Set class
     *
     * @param string $class
     *
     * @return Menu
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
}
