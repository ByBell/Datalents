<?php

namespace App\Repository;

use App\Entity\UserProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
use PDO;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserProfileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserProfile::class);
    }


    public function search($query)
    {
        $sql = "SELECT id, photo, firstname, lastname, title, resume, skills, hobbies,
        MATCH (firstname, lastname, title, resume, skills, hobbies) AGAINST (:query IN BOOLEAN MODE) AS pertinency
        FROM user_profile
        WHERE MATCH (firstname, lastname, title, resume, skills, hobbies) AGAINST (:query IN BOOLEAN MODE) > 0
        ORDER BY pertinency DESC
        ";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute(['query' => '*'.$query.'*']);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

}
