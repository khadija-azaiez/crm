<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findProductsGraterThanValue($value)
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.label, p.prix, supplier2.id as idsupplier2, supplier2.name as namesupplier2')
            ->leftJoin('p.supplier', 'supplier2')
            ->where('p.prix >= :val')
            ->setParameter('val', $value)
            ->orderBy('p.prix', 'DESC')
            ->getQuery()
            ->getResult();
    }


    public function getAllProducts()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p.id, p.label, p.prix, supplier2.id as idsupplier2, supplier2.name as namesupplier2')
            ->leftJoin('p.supplier', 'supplier2');

        return $qb->getQuery()->getResult();
    }
}