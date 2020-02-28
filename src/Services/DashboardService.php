<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

class DashboardService
{
    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    public function getUsersCount()
    {
        return $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\User  as u ')->getSingleScalarResult();
    }
    public function getAdsCount()
    {
        return $this->manager->createQuery('SELECT COUNT(a) FROM App\Entity\Ad  as a ')->getSingleScalarResult();
    }
    public function getReservationsCount()
    {
        return $this->manager->createQuery('SELECT COUNT(b) FROM App\Entity\Booking  as b ')->getSingleScalarResult();
    }
    public function getCommentsCount()
    {
        return $this->manager->createQuery('SELECT COUNT(c) FROM App\Entity\Comment  as c ')->getSingleScalarResult();
    }
    public function getStatAds($orderBy)
    {
        return $this->manager->createQuery('SELECT AVG(c.rating) as note , a.title , u.firstName,u.lastName 
                                     FROM App\Entity\Comment c
                                     JOIN c.ad a
                                     JOIN c.user u
                                     GROUP BY a
                                     ORDER BY note '.$orderBy
                                     )->setMaxResults(5)
            ->getResult();
    }
   
}
