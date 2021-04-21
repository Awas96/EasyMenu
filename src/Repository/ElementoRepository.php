<?php

namespace App\Repository;

use App\Entity\Elemento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Elemento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Elemento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Elemento[]    findAll()
 * @method Elemento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElementoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Elemento::class);
    }

    // /**
    //  * @return Elemento[] Returns an array of Elemento objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findSecOrderBy($Seccion)
    {
        return $this->createQueryBuilder('s')
            ->where('s.seccion = :seccion')
            ->setParameter('seccion', $Seccion)
            ->orderBy('s.orden', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function listarElementos($Seccion)
    {
        return $this->createQueryBuilder('e')
            ->where('e.seccion = :seccion')
            ->setParameter('seccion', $Seccion)
            ->getQuery()
            ->getResult();
    }

    public function GetElementByID($id)
    {
        return $this->createQueryBuilder('e')
            ->where('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
