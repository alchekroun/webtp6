<?php

namespace App\Repository;

use App\Entity\Espece;
use App\Entity\Type;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Espece|null find($id, $lockMode = NULL, $lockVersion = NULL)
 * @method Espece|null findOneBy(array $criteria, array $orderBy = NULL)
 * @method Espece[]    findAll()
 * @method Espece[]    findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
 */
class EspeceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Espece::class);
    }

    public function findRandomByType(Type $type)
    {
        $conn = $this->getEntityManager()->getConnection();
        $rawSql = "SELECT * FROM espece WHERE id IN (SELECT espece_id FROM espece_type WHERE espece_type.type_id = :tt)";
        $stmt = $conn->prepare($rawSql);
        $stmt->execute(['tt' => $type->getId()]);
        $espece_by_type = $stmt->fetchAll();
        $tok = rand(0, sizeof($espece_by_type) - 1);
        if (isset($espece_by_type)) {
            return $espece_by_type[$tok];
        }

        return NULL;
    }
    // /**
    //  * @return Espece[] Returns an array of Espece objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Espece
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
