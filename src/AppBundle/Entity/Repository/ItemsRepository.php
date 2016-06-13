<?php
/**
 * Created by PhpStorm.
 * User: donatas
 * Date: 16.6.12
 * Time: 12.31
 */

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ItemsRepository extends EntityRepository
{
    public function getRecentFeedItems($feedId, $limit = 5)
    {
        $result = $this
            ->createQueryBuilder('i')
            ->select('i')
            ->andWhere('i.feed = :feedId')
            ->setParameter('feedId', $feedId)
            ->orderBy('i.published', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults($limit)
            ->getQuery()
        ;

        return $result->getResult();
    }
}