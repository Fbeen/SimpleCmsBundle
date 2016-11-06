<?php

namespace Fbeen\SimpleCmsBundle\Repository;

/**
 * RouteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RouteRepository extends \Doctrine\ORM\EntityRepository
{
    public function findRouteWithCompleteContent($name)
    {
        return $this->getEntityManager()->createQuery(
            'SELECT r, c, t, bc, b FROM FbeenSimpleCmsBundle:Route r
            LEFT JOIN r.content c
            LEFT JOIN c.translations t
            LEFT JOIN c.blockContainers bc
            LEFT JOIN bc.blocks b
            WHERE r.name=:name'
        )   ->setParameter('name', $name)
            ->getOneOrNullResult();        
    }
}