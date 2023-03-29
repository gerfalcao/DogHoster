<?php

namespace App\Repository;

use App\Entity\Hospedagem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hospedagem>
 *
 * @method Hospedagem|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hospedagem|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hospedagem[]    findAll()
 * @method Hospedagem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HospedagemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hospedagem::class);
    }

    public function save(Hospedagem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Hospedagem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findHospedagemsEmAberto(): array 
    {
        return $this->createQueryBuilder('h')->andWhere('h.data_fim IS NULL')->getQuery()->getResult();
    }

    public function findHospedagemsFechadas(): array 
    {
        return $this->createQueryBuilder('h')->andWhere('h.data_fim IS NOT NULL')->getQuery()->getResult();
    }

//    /**
//     * @return Hospedagem[] Returns an array of Hospedagem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Hospedagem
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
