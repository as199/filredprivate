<?php


namespace App\Service;


use ApiPlatform\Core\Api\IriConverterInterface;
use App\Repository\PromoRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Serializer\SerializerInterface;

class PromoService
{
    /**
     * @var PromoRepository
     */
    private PromoRepository $promoRepository;


    /**
     * PromoService constructor.
     */
    public function __construct(IriConverterInterface $iriConverter,SerializerInterface $serializer,PromoRepository $promoRepository)
    {
        $this->promoRepository = $promoRepository;
    }

    /**
     * @param null $id
     * @return QueryBuilder
     */
    public function getPromoPrincipale($id= null){

        $dt= $this->promoRepository->getPromoGroupePrincipal($id);
        return $dt;
    }
    public function getApprenantAttente(){
        return $this->promoRepository->findApprenantAttente();
    }

    public function getApprenantPromoAttente(){
        return $this->promoRepository->findApprenantPromoAttente();
    }

    public function getFormateur(){
        return $this->promoRepository->findFormateur();
    }
}