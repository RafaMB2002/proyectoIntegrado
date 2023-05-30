<?php

namespace App\Repository;

use App\Entity\DetalleComandaBebida;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DetalleComandaBebida>
 *
 * @method DetalleComandaBebida|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetalleComandaBebida|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetalleComandaBebida[]    findAll()
 * @method DetalleComandaBebida[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetalleComandaBebidaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetalleComandaBebida::class);
    }

    public function save(DetalleComandaBebida $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DetalleComandaBebida $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DetalleComandaBebida[] Returns an array of DetalleComandaBebida objects
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

//    public function findOneBySomeField($value): ?DetalleComandaBebida
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
