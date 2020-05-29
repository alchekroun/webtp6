<?php

namespace App\Repository;

use App\Entity\Espece;
use App\Entity\Type;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Espece|null find($id, $lockMode = null, $lockVersion = null)
 * @method Espece|null findOneBy(array $criteria, array $orderBy = null)
 * @method Espece[]    findAll()
 * @method Espece[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
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
        if(isset($espece_by_type))
        {
            return $espece_by_type[$tok];
        }
        return null;
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

    public function initdb()
    {
        $conn = $this->getEntityManager()->getConnection();
        $rawSql = "INSERT INTO espece (nom, courbe_xp, evolution)
                            VALUES ('Bulbizarre', 'P', 'n'),
                                    ('Herbizarre', 'P', 'o'),
                                    ('Florizarre', 'P', 'o'),
                                    ('Salameche', 'P', 'n'),
                                    ('Reptincel', 'P', 'o'),
                                    ('Dracaufeu', 'P', 'o'),
                                    ('Carapuce', 'P', 'n'),
                                    ('Carabaffe', 'P', 'o'),
                                    ('Tortank', 'P', 'o'),
                                    ('Chenipan', 'M', 'n'),
                                    ('Chrysacier', 'M', 'o'),
                                    ('Papilusion', 'M', 'o'),
                                    ('Aspicot', 'M', 'n'),
                                    ('Coconfort', 'M', 'o'),
                                    ('Dardargnan', 'M', 'o'),
                                    ('Roucool', 'P', 'n'),
                                    ('Roucoups', 'P', 'o'),
                                    ('Roucarnage', 'P', 'o'),
                                    ('Rattata', 'M', 'n'),
                                    ('Rattatac', 'M', 'o'),
                                    ('Piafabec', 'M', 'n'),
                                    ('Rapasdepic', 'M', 'o'),
                                    ('Abo', 'M', 'n'),
                                    ('Arbok', 'M', 'o'),
                                    ('Pikachu', 'M', 'n'),
                                    ('Raichu', 'M', 'o'),
                                    ('Sabelette', 'M', 'n'),
                                    ('Sablaireau', 'M', 'o'),
                                    ('Nidoran', 'P', 'n'),
                                    ('Nidorina', 'P', 'o');";
        $stmt = $conn->prepare($rawSql);
        $stmt->execute();
        $rawSql = "INSERT INTO espece (nom, courbe_xp, evolution)
                            VALUES ('Nidoqueen', 'P', 'o'),
                                    ('Nidoran', 'P', 'n'),
                                    ('Nidorino', 'P', 'o'),
                                    ('Nidoking', 'P', 'o'),
                                    ('Mélofée', 'R', 'n'),
                                    ('Mélodelfe', 'R', 'o'),
                                    ('Goupix', 'M', 'n'),
                                    ('Feunard', 'M', 'o'),
                                    ('Rondoudou', 'R', 'n'),
                                    ('Grodoudou', 'R', 'o'),
                                    ('Nosferapti', 'M', 'n'),
                                    ('Nosferalto', 'M', 'o'),
                                    ('Mystherbe', 'P', 'n'),
                                    ('Ortide', 'P', 'o'),
                                    ('Rafflesia', 'P', 'o'),
                                    ('Paras', 'M', 'n'),
                                    ('Parasect', 'M', 'o'),
                                    ('Mimitoss', 'M', 'n'),
                                    ('Aéromite', 'M', 'o'),
                                    ('Taupiqueur', 'M', 'n'),
                                    ('Triopikeur', 'M', 'o'),
                                    ('Miaouss', 'M', 'n'),
                                    ('Persian', 'M', 'o'),
                                    ('Psykokwak', 'M', 'n'),
                                    ('Akwakwak', 'M', 'o'),
                                    ('Férosinge', 'M', 'n'),
                                    ('Colossinge', 'M', 'o'),
                                    ('Caninos', 'L', 'n'),
                                    ('Arcanin', 'L', 'o'),
                                    ('Ptitard', 'P', 'n');";
        $stmt = $conn->prepare($rawSql);
        $stmt->execute();
        $rawSql = "INSERT INTO espece (nom, courbe_xp, evolution)
                            VALUES  ('Tétarte', 'P', 'o'),
                                    ('Tartard', 'P', 'o'),
                                    ('Abra', 'P', 'n'),
                                    ('Kadabra', 'P', 'o'),
                                    ('Alakazam', 'P', 'o'),
                                    ('Machoc', 'P', 'n'),
                                    ('Machopeur', 'P', 'o'),
                                    ('Mackogneur', 'P', 'o'),
                                    ('Chétiflor', 'P', 'n'),
                                    ('Boustiflor', 'P', 'o'),
                                    ('Empiflor', 'P', 'o'),
                                    ('Tentacool', 'L', 'n'),
                                    ('Tentacruel', 'L', 'o'),
                                    ('Racaillou', 'P', 'n'),
                                    ('Gravalanch', 'P', 'o'),
                                    ('Grolem', 'P', 'o'),
                                    ('Ponyta', 'M', 'n'),
                                    ('Galopa', 'M', 'o'),
                                    ('Ramoloss', 'M', 'n'),
                                    ('Flagadoss', 'M', 'o'),
                                    ('MagnÃ©ti', 'M', 'n'),
                                    ('MagnÃŒÂ©ton', 'M', 'o'),
                                    ('Canarticho', 'M', 'n'),
                                    ('Doduo', 'M', 'n'),
                                    ('Dodrio', 'M', 'o'),
                                    ('Otaria', 'M', 'n'),
                                    ('Lamantine', 'M', 'o'),
                                    ('Tadmorv', 'M', 'n'),
                                    ('Grotadmorv', 'M', 'o'),
                                    ('Kokiyas', 'L', 'n');";
        $stmt = $conn->prepare($rawSql);
        $stmt->execute();
        $rawSql = "INSERT INTO espece (nom, courbe_xp, evolution)
                            VALUES  ('Crustabri', 'L', 'o'),
                                    ('Fantominus', 'P', 'n'),
                                    ('Spectrum', 'P', 'o'),
                                    ('Ectoplasma', 'P', 'o'),
                                    ('Onix', 'M', 'n'),
                                    ('Soporifik', 'M', 'n'),
                                    ('Hypnomade', 'M', 'o'),
                                    ('Krabby', 'M', 'n'),
                                    ('Krabboss', 'M', 'o'),
                                    ('Voltorbe', 'M', 'n'),
                                    ('Electrode', 'M', 'o'),
                                    ('Noeunoeuf', 'L', 'n'),
                                    ('Noadkoko', 'L', 'o'),
                                    ('Osselait', 'M', 'n'),
                                    ('Ossatueur', 'M', 'o'),
                                    ('Kicklee', 'M', 'n'),
                                    ('Tygnon', 'M', 'n'),
                                    ('Excelangue', 'M', 'n'),
                                    ('Smogo', 'M', 'n'),
                                    ('Smogogo', 'M', 'o'),
                                    ('Rhinocorne', 'L', 'n'),
                                    ('Rhinoféros', 'L', 'o'),
                                    ('Leveinard', 'R', 'n'),
                                    ('Saquedeneu', 'M', 'n'),
                                    ('Kangourex', 'M', 'n'),
                                    ('Hypotrempe', 'M', 'n'),
                                    ('Hypocéan', 'M', 'o'),
                                    ('Poissirène', 'M', 'n'),
                                    ('Poissoroy', 'M', 'o'),
                                    ('Stari', 'L', 'n');";
        $stmt = $conn->prepare($rawSql);
        $stmt->execute();
        $rawSql = "INSERT INTO espece (nom, courbe_xp, evolution)
                            VALUES  ('Staross', 'L', 'o'),
                                    ('M. Mime', 'M', 'n'),
                                    ('Insécateur', 'M', 'n'),
                                    ('Lippoutou', 'M', 'n'),
                                    ('Elektek', 'M', 'n'),
                                    ('Magmar', 'M', 'n'),
                                    ('Scarabrute', 'L', 'n'),
                                    ('Tauros', 'L', 'n'),
                                    ('Magicarpe', 'L', 'n'),
                                    ('Léviator', 'L', 'o'),
                                    ('Lokhlass', 'L', 'n'),
                                    ('Métamorph', 'M', 'n'),
                                    ('Evoli', 'M', 'n'),
                                    ('Aquali', 'M', 'o'),
                                    ('Voltali', 'M', 'o'),
                                    ('Pyroli', 'M', 'o'),
                                    ('Porygon', 'M', 'n'),
                                    ('Amonita', 'M', 'n'),
                                    ('Amonistar', 'M', 'o'),
                                    ('Kabuto', 'M', 'n');";
        $stmt = $conn->prepare($rawSql);
        $stmt->execute();
        $rawSql = "INSERT INTO espece (nom, courbe_xp, evolution)
                            VALUES  ('Kabutops', 'M', 'o'),
                                    ('Ptéra', 'L', 'n'),
                                    ('Ronflex', 'L', 'n'),
                                    ('Artikodin', 'L', 'n'),
                                    ('Electhor', 'L', 'n'),
                                    ('Sulfura', 'L', 'n'),
                                    ('Minidraco', 'L', 'n'),
                                    ('Draco', 'L', 'o'),
                                    ('Dracolosse', 'L', 'o'),
                                    ('Mewtwo', 'L', 'n'),
                                    ('Mew', 'P', 'n');";
        $stmt = $conn->prepare($rawSql);
        $stmt->execute();
    }
}
