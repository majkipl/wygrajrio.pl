<?php

namespace App\Repository;

use App\Entity\Where;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Where>
 *
 * @method Where|null find($id, $lockMode = null, $lockVersion = null)
 * @method Where|null findOneBy(array $criteria, array $orderBy = null)
 * @method Where[]    findAll()
 * @method Where[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WhereRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Where::class);
    }

    /**
     * @param Where $entity
     * @param bool $flush
     * @return void
     */
    public function save(Where $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Where $entity
     * @param bool $flush
     * @return void
     */
    public function remove(Where $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
