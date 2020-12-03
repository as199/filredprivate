<?php

namespace App\Repository;

use App\Entity\Promo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Promo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Promo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Promo[]    findAll()
 * @method Promo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promo::class);
    }

    // /**
    //  * @return Promo[] Returns an array of Promo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Promo
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getPromoGroupePrincipal($id = null)
    {
        $results= $this->createQueryBuilder('p')
            ->select('p,g,a')
            ->leftJoin('p.groupes','g')
            ->andWhere('g.type =:type')
            ->setParameter('type', "principale")
            ->leftJoin('g.apprenants','a')
            ->andWhere('a.status =:archiver')
            ->setParameter('archiver', false);
            if($id){
                $results->andWhere('p.id =:idpromo')
                    ->setParameter('idpromo', $id);
            }

           // dd($results);
            return $results;
    }

    public function findApprenantAttente()
    {
       return  $this->createQueryBuilder('p')
            ->select('p,g,a')
            ->leftJoin('p.groupes','g')
            ->andWhere('g.type =:type')
            ->setParameter('type', "principale")
            ->leftJoin('g.apprenants','a')
            ->andWhere('a.attente =:attente')
            ->setParameter('attente', true)
            ->andWhere('a.status =:status')
            ->setParameter('status', false);

    }

    public function findFormateur()
    {
        return  $this->createQueryBuilder('p')
            ->select('p,g,f')
            ->leftJoin('p.groupes','g')
            ->andWhere('g.status =:type')
            ->setParameter('type', false)
            ->leftJoin('g.formateurs','f')
            ->andWhere('f.status =:status')
            ->setParameter('status', false);

    }

    public function findApprenantPromoAttente()
    {
        return  $this->createQueryBuilder('p')
            ->select('p,a')
            ->leftJoin('g.apprenants','g')
            ->andWhere('g.attente =:attente')
            ->setParameter('attente', true)
            ->andWhere('a.status =:status')
            ->setParameter('status', false);

    }
}
