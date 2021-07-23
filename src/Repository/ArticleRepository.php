<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
    * @return Article[] Returns an array of Article objects
    */
    public function findLatestPublished()
    {
        $queryBuilder = $this->createQueryBuilder('a');
        return $this->latest($this->published($queryBuilder))
                        ->getQuery()
                        ->getResult()
        ;
    }

    /**
    * @return Article[] Returns an array of Article objects
    */
    public function findLatest()
    {
        return $this->latest()
                    ->getQuery()
                    ->getResult()
        ;
    }

    /**
    * @return Article[] Returns an array of Article objects
    */
    public function findPublished()
    {
        return $this->published()
                    ->getQuery()
                    ->getResult()
        ;
    }

    public function published(QueryBuilder $qb =  null)
    {
        return $this->gerOrCreateQueryBuilder($qb)->andWhere(' a.publishedAt IS NOT NULL');
    }

    public function latest(QueryBuilder $qb = null)
    {
        return $this->gerOrCreateQueryBuilder($qb)->orderBy(' a.publishedAt', 'DESC');
    }

    public function gerOrCreateQueryBuilder (?QueryBuilder $qb): QueryBuilder
    {
        return $qb ?? $this->createQueryBuilder('a');
    }
    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
