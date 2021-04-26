<?php

namespace App\Repository;

use App\Entity\Spend;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Spend|null find($id, $lockMode = null, $lockVersion = null)
 * @method Spend|null findOneBy(array $criteria, array $orderBy = null)
 * @method Spend[]    findAll()
 * @method Spend[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpendRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Spend::class);
    }

    /**
     * @return Spend[] Returns an array of Spend objects
     */
    public function findBySpendField($montant, $label)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.montant >= :montantRecherche')
            ->andWhere('s.label LIKE :labelRecherche')
            ->setParameter('montantRecherche', $montant)
            ->setParameter('labelRecherche', '%'.$label.'%')
            ->orderBy('s.montant', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function getAllSpends()
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s.id, s.label, s.date, s.montant, supplier1.id as idSupplier, supplier1.name as nameSupplier')
            ->leftJoin('s.supplier', 'supplier1')
        ;

        return $qb->getQuery()->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Spend
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
