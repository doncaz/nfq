<?php
/**
 * Created by PhpStorm.
 * User: donatas
 * Date: 16.6.12
 * Time: 12.31
 */

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

class FeedsRepository extends EntityRepository
{
    public function getList($options = [])
    {
        $result = $this
            ->createQueryBuilder('i')
            ->select('i')
        ;

        if (isset($options['category'])) {
            $result
                ->andWhere('i.category = :category')
                ->setParameter('category', $options['category'])
                ;
        }

        $query = $result->getQuery();

        return $query->getResult();
    }
}