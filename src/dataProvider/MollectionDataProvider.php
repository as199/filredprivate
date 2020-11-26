<?php


namespace App\dataProvider;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\PaginationExtension;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Doctrine\Persistence\ManagerRegistry;

class MollectionDataProvider  implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $manager;
    /**
     * @var PaginationExtension
     */
    private PaginationExtension $paginator;
    private $context;

    /**
     * MollectionDataProvider constructor.
     */
    public function __construct(PaginationExtension $paginator,ManagerRegistry $manager)
    {
        $this->paginator = $paginator;
        $this->manager =$manager;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        $this->context =$context;
        return $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        $collection =$this->manager
            ->getManagerForClass($resourceClass)
            ->getRepository($resourceClass)->createQueryBuilder('item')
            ->where('item.status = :deleted')
            ->setParameter('deleted',false);
        $this->paginator->applyToCollection($collection, new QueryNameGenerator(),$resourceClass,$operationName,$this->context);
        return $collection->getQuery()->getResult();
    }
}