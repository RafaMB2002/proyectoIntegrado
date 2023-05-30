<?php

namespace App\Repository;

use App\Entity\DetalleComandaPlato;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DetalleComandaPlato>
 *
 * @method DetalleComandaPlato|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetalleComandaPlato|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetalleComandaPlato[]    findAll()
 * @method DetalleComandaPlato[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetalleComandaPlatoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetalleComandaPlato::class);
    }

    public function save(DetalleComandaPlato $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DetalleComandaPlato $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DetalleComandaPlato[] Returns an array of DetalleComandaPlato objects
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

//    public function findOneBySomeField($value): ?DetalleComandaPlato
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
