<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    /**
     * @return Project[] Returns an array of JobOffer objects
     */
    public function findWithFilters(array $filters): array
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->andWhere('p.title LIKE :title')
            ->setParameter('title', '%' . $filters['title'] . '%');

        if (isset($filters['category'])) {
            $qb
                ->andWhere('p.categoryName IN (:name)')
                ->setParameter('name', $filters['category']);
        }

        if (isset($filters['codeLanguage'])) {
            $qb
                ->andWhere('p.codeLanguageName IN (:name)')
                ->setParameter('name', $filters['codeLanguage']);
        }

        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Project[] Returns an array of Project objects
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
    public function findOneBySomeField($value): ?Project
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
