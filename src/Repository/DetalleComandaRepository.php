<?php

namespace App\Repository;

use App\Entity\DetalleComanda;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DetalleComanda>
 *
 * @method DetalleComanda|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetalleComanda|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetalleComanda[]    findAll()
 * @method DetalleComanda[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetalleComandaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetalleComanda::class);
    }

    public function save(DetalleComanda $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DetalleComanda $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DetalleComanda[] Returns an array of DetalleComanda objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DetalleComanda
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
