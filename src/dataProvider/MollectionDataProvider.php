<?php


namespace App\dataProvider;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\PaginationExtension;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Service\PromoService;
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
     * @var PromoService
     */
    private PromoService $promoService;

    /**
     * MollectionDataProvider constructor.
     */
    public function __construct(PaginationExtension $paginator,ManagerRegistry $manager,PromoService $promoService)
    {
        $this->paginator = $paginator;
        $this->manager =$manager;
        $this->promoService = $promoService;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        $this->context =$context;
        return $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        if ($operationName == "get_groupe_principale"){
            $collection = $this->promoService->getPromoPrincipale();
        }elseif($operationName =="get_apprenant_attente"){
            $collection = $this->promoService->getApprenantAttente();
        }elseif ($operationName == "referenceApprenantAttente"){
            $collection = $this->promoService->getApprenantAttente();
        }elseif ($operationName == "promoformateur"){
            $collection = $this->promoService->getFormateur();
        }
        else {
            $collection = $this->manager
                ->getManagerForClass($resourceClass)
                ->getRepository($resourceClass)->createQueryBuilder('item')
                ->where('item.status = :deleted')
                ->setParameter('deleted', false);
            $this->paginator->applyToCollection($collection, new QueryNameGenerator(), $resourceClass, $operationName, $this->context);
        }
        return $collection->getQuery()->getResult();
    }
}