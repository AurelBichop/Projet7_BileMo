<?php

namespace App\Repository;

use App\Entity\Telephone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Telephone|null find($id, $lockMode = null, $lockVersion = null)
 * @method Telephone|null findOneBy(array $criteria, array $orderBy = null)
 * @method Telephone[]    findAll()
 * @method Telephone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TelephoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Telephone::class);
    }


    /**
     * Permet de retourner les teléphones avec une pagination
     *
     * @param int $page
     * @param int $limit
     * @return Paginator
     */
    public function findAllByPage(int $page,int $limit){

        $query = $this->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC')
            ->getQuery()
            ->setFirstResult(($page -1)*$limit)
            ->setMaxResults($limit);

        return new Paginator($query);

    }
    // /**
    //  * @return Telephone[] Returns an array of Telephone objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Telephone
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
