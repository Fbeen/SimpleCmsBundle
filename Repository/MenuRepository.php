<?php

namespace Fbeen\SimpleCmsBundle\Repository;

/**
 * MenuRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MenuRepository extends \Doctrine\ORM\EntityRepository
{
    public function findMenu($name)
    {
        return $this->getEntityManager()->createQuery(
            'SELECT m, i, t FROM FbeenSimpleCmsBundle:Menu m
            LEFT JOIN m.menuitems i
            LEFT JOIN i.translations t
            WHERE m.name=:name'
        )   ->setParameter('name', $name)
            ->getOneOrNullResult();        
    }
}