<?php

namespace App\Repository;

use App\Entity\Recibo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recibo>
 *
 * @method Recibo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recibo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recibo[]    findAll()
 * @method Recibo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReciboRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recibo::class);
    }

    public function save(Recibo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Recibo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listaRecentes(): array
    {
        return $this->createQueryBuilder('r')->orderBy('r.data_fechamento', 'DESC')->getQuery()->getResult();    // #[Route('/', name: 'app_hospedagem_index', methods: ['GET'])]
        // public function index(HospedagemRepository $hospedagemRepository): Response
        // {
        //     // $hospedagems = $hospedagemRepository->findAll();
        //     $hospedagensAtivas = $hospedagemRepository->findBy(['estado' => 'em aberto']);
    
        //     return $this->render('hospedagem/index.html.twig', [
        //         // 'hospedagems' => $hospedagems,
        //         'hospedagensAtivas' => $hospedagensAtivas,
    
        //     ]);
        // }
    }

//    /**
//     * @return Recibo[] Returns an array of Recibo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Recibo
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
