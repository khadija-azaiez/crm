<?php

namespace App\Repository;

use App\Entity\Credit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Credit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Credit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Credit[]    findAll()
 * @method Credit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreditRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Credit::class);
    }

    /**
     * @return Credit[] Returns an array of Credit objects
     */
    public function getAllCredits()
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c.id, SUM(c.montant) as montant, MAX(c.date) as date, customer.id as idCustomer, customer.name as nameCustomer')
            ->leftJoin('c.customer', 'customer')
            ->groupBy('customer.id')
        ;

        return $qb->getQuery()->getResult();
    }



    public function findCreditByCustomer($value)
    {
        return $this->createQueryBuilder('c')
            ->select('c.id, SUM(c.montant) as montant, MAX(c.date) as date, customer.id as idCustomer, customer.name as nameCustomer')
            ->leftJoin('c.customer', 'customer')
            ->andWhere('customer.name LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->orderBy('customer.name')
            ->groupBy('customer.id')
            ->getQuery()
            ->getResult()
        ;
    }

}
