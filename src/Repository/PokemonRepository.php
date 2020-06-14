<?php

namespace App\Repository;

use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pokemon|null find($id, $lockMode = NULL, $lockVersion = NULL)
 * @method Pokemon|null findOneBy(array $criteria, array $orderBy = NULL)
 * @method Pokemon[]    findAll()
 * @method Pokemon[]    findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
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

    /**
     * @param Pokemon $pokemon
     * @return int|NULL
     */
    public function getNiveau(Pokemon $pokemon)
    {
        $espece = $pokemon->getEspece();
        if ($espece->getCourbeXP() === 'R') {
            return (int) floor(0.8 * pow($pokemon->getXp(), 1 / 3));
        } else {
            if ($espece->getCourbeXP() === 'M') {
                return (int) floor(pow($pokemon->getXp(), 1 / 3));
            } else {
                if ($espece->getCourbeXP() === 'P') {
                    for ($i = 5; $i < 100; $i++) {
                        if ($pokemon->getXp() < (1.2 * pow($i, 3) - 15 * pow($i, 2) + 100 * $i - 140)) {
                            return $i-1;
                        }
                    }
                } else {
                    if ($espece->getCourbeXP() === 'L') {
                        return (int) floor(1.25 * pow($pokemon->getXp(), 1 / 3));
                    }
                }
            }
        }

        return NULL;
    }

    /**
     * @param Pokemon $pkm
     * @return Pokemon
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function verifyAndLevelUp(Pokemon $pkm)
    {
        if ($pkm->getNiveau() < $this->getNiveau($pkm)) {
            $pkm->setNiveau($this->getNiveau($pkm));
            $this->_em->persist($pkm);
            $this->_em->flush();
        }

        return $pkm;
    }

    /**
     * @return Pokemon[] Returns an array of Pokemon objects
     */
    public function findAllPurchasable()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.status = :st')
            ->setParameter('st', "avendre")
            ->getQuery()
            ->getResult();
    }
}
