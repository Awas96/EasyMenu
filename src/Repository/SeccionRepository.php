<?php

namespace App\Repository;

use App\Entity\Seccion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Seccion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seccion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seccion[]    findAll()
 * @method Seccion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeccionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seccion::class);
    }

    // /**
    //  * @return Seccion[] Returns an array of Seccion objects
    //  */

    public function findAllOrderBy()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.orden', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findById($id): ?Seccion
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
