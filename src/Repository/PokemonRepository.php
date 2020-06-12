<?php

namespace App\Repository;

use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pokemon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pokemon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pokemon[]    findAll()
 * @method Pokemon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pokemon::class);
    }

    // /**
    //  * @return Pokemon[] Returns an array of Pokemon objects
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
    public function findOneBySomeField($value): ?Pokemon
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getNiveau(Pokemon $pokemon)
    {
        $espece = $pokemon->getEspece();
        if($espece->getCourbeXP() === 'R'){
            return round(0.8 * pow($pokemon->getXp(), 1/3));
        } else if ($espece->getCourbeXP() === 'M') {
            return round(pow($pokemon->getXp(), 1/3));
        } else if ($espece->getCourbeXP() === 'P') {
            for($i = 5; $i < 100; $i++) {
                if ($pokemon->getXp() > (1.2 * pow($i, 3) - 15 * pow($i, 2) + 100 * $i - 140)) {
                    return $i;
                }
            }
        } else if ($espece->getCourbeXP() === 'L') {
            return round(1.25 * pow($pokemon->getXp(), 1/3));
        }
        return null;
    }

    public function findAllPurchasable()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.status = :st')
            ->setParameter('st', "avendre")
            ->getQuery()
            ->getResult();
    }
}
