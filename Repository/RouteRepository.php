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
            'SELECT r, c, t, b FROM FbeenSimpleCmsBundle:Route r
            LEFT JOIN r.content c
            LEFT JOIN c.translations t
            LEFT JOIN c.blocks b
            WHERE r.name=:name AND r.enabled=1'
        )   ->setParameter('name', $name)
            ->getOneOrNullResult();        
    }
    
    public function findAllEnabled()
    {
        return $this->getEntityManager()->createQuery(
            'SELECT r FROM FbeenSimpleCmsBundle:Route r
            WHERE r.enabled=1'
        )   ->getResult();        
    }
}
