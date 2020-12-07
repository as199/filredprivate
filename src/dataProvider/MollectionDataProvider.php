<?php


namespace App\dataProvider;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\PaginationExtension;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Apprenant;
use App\Repository\ApprenantRepository;
use App\Repository\BriefMaPromoRepository;
use App\Repository\ChatRepository;
use App\Repository\FormateurRepository;
use App\Repository\GroupeRepository;
use App\Repository\PromoRepository;
use App\Service\LivrablePartielService;
use App\Service\ProfilSortiService;
use App\Service\PromoService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;

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
     * @var LivrablePartielService
     */
    private LivrablePartielService $livrablePartielService;
    /**
     * @var ProfilSortiService
     */
    private ProfilSortiService $profilSortiService;
    /**
     * @var ApprenantRepository
     */
    private ApprenantRepository $apprenantRepository;
    /**
     * @var ChatRepository
     */
    private ChatRepository $chatRepository;
    /**
     * @var PromoRepository
     */
    private PromoRepository $promoRepository;
    /**
     * @var GroupeRepository
     */
    private GroupeRepository $groupeRepository;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;
    /**
     * @var FormateurRepository
     */
    private FormateurRepository $formateurRepository;
    /**
     * @var BriefMaPromoRepository
     */
    private BriefMaPromoRepository $briefMaPromoRepository;

    /**
     * MollectionDataProvider constructor.
     */
    public function __construct(SerializerInterface $serializer,ApprenantRepository $apprenantRepository,PromoRepository $promoRepository,
         PaginationExtension $paginator,ManagerRegistry $manager,ChatRepository $chatRepository,GroupeRepository $groupeRepository
        ,PromoService $promoService,LivrablePartielService $livrablePartielService,
          ProfilSortiService $profilSortiService, FormateurRepository $formateurRepository,
                                BriefMaPromoRepository $briefMaPromoRepository)
    {
        $this->paginator = $paginator;
        $this->manager =$manager;
        $this->promoService = $promoService;
        $this->livrablePartielService = $livrablePartielService;
        $this->profilSortiService = $profilSortiService;
        $this->apprenantRepository = $apprenantRepository;
        $this->chatRepository = $chatRepository;
        $this->promoRepository = $promoRepository;
        $this->groupeRepository = $groupeRepository;
        $this->serializer = $serializer;
        $this->formateurRepository = $formateurRepository;
        $this->briefMaPromoRepository = $briefMaPromoRepository;
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
        }elseif ($operationName =="addLivrable"){
            //dd("ddfzrfer");
            $data = explode("/",$context["request_uri"]);
            $id =(int)$data[4];
            $id1 =(int)$data[6];
            $collection = $this->livrablePartielService->getReferencielApprenantCompetence($id,$id1);

        }elseif ($operationName == "apprenantProfilSortie"){
            $data = explode("/",$context["request_uri"]);
            dd($data);
            $id = (int)$data[4];
           // dd($id);
            $collection = $this->profilSortiService->getApprenanttProfilSorti($id);
            return $collection;
        }elseif ($operationName == "afficherAppProfilSorti"){
            $data = explode("/",$context["request_uri"]);
            $id =(int)$data[4];
            $id1 =(int)$data[6];
            $collection = $this->apprenantRepository->recuperApprenants($id,$id1);
            //dd($collection);
        }elseif ($operationName == "get_formateur_id_brief"){
            $data = explode("/",$context["request_uri"]);
            //dd($data);
            $id =(int)$data[3];
            $collection = $this->formateurRepository->recupBrief($id);
            //dd($infos);
        }elseif ($operationName =="get_formateur_id_brief_valide"){
            $data = explode("/",$context["request_uri"]);
            //dd($data);
            $id =(int)$data[3];
            $collection = $this->formateurRepository->recupBriefValide($id);
            //dd($collection);
        }elseif ($operationName == "get_formateur_id_brief_promo"){
            $data = explode("/",$context["request_uri"]);
            $id =(int)$data[4];
            $id1 =(int)$data[6];
            $collection = $this->briefMaPromoRepository->findOneBySomeField($id,$id1);
            //dd($data);
        }elseif ($operationName == "get_livrablepartiel1"){
            $data = explode("/",$context["request_uri"]);
            $id =(int)$data[4];
            $id1 =(int)$data[6];
            $collection = $this->manager->getRepository(Apprenant::class)
                ->createQueryBuilder('a')
                ->innerJoin('a.promo', 'p')
                ->andWhere('p.id = :idp')
                ->setParameter('idp',$id)
                ->innerJoin('p.referenciels','r')
                ->andWhere('r.id = :idR')
                ->setParameter('idR',$id1);

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