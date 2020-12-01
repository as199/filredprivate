<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Repository\ApprenantRepository;
use App\Repository\FormateurRepository;
use App\Repository\PromoRepository;
use App\Service\ValidatorPost;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupeController extends AbstractController
{
    /**
     * @var ApprenantRepository
     */
    private ApprenantRepository $apprenantRepository;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var FormateurRepository
     */
    private FormateurRepository $formateurRepository;
    /**
     * @var PromoRepository
     */
    private PromoRepository $promoRepository;
    /**
     * @var ValidatorPost
     */
    private ValidatorPost $validator;

    /**
     * GroupeController constructor.
     */
    public function __construct(EntityManagerInterface $manager,
                                ApprenantRepository $apprenantRepository,
                                FormateurRepository $formateurRepository,
                                PromoRepository $promoRepository,
                                ValidatorPost $validator
    )
    {
        $this->manager =$manager;
        $this->apprenantRepository = $apprenantRepository;
        $this->formateurRepository = $formateurRepository;
        $this->promoRepository = $promoRepository;
        $this->validator = $validator;
    }

    public function addGroupes(Request $request)
    {
        $json = json_decode($request->getContent(),true);

        $groupe = new Groupe();
        $groupe->setNomGroupe($json['nomGroupe'])
            ->setDateCreation(new \DateTime())
            ->setStatus($json['status']);
        //add groupe in promos
        ;
        if (isset($json['promo'])) {
            $promo = $this->promoRepository->find($json['promo']);
           //dd($promo);
            $groupe->setPromos($promo);
        }
        if (isset($json['apprenants'])) {
            for ($i= 0; $i < count($json['apprenants']); $i++) {
                $apprenant = $this->apprenantRepository->find($json['apprenants'][$i]['id']);
                $groupe->addApprenant($apprenant);
            }
        }
        if (isset($json['formateurs'])) {
            for ($i= 0; $i < count($json['formateurs']); $i++) {
                $formateur = $this->formateurRepository->find($json['formateurs'][$i]['id']);
                $groupe->addFormateur($formateur);
            }
        }
        $errors = $this->validator->ValidatePost($groupe);
        if ($errors) {
            return $this->json($errors,Response::HTTP_BAD_REQUEST);
        }
        $this->manager->persist($groupe);
        $this->manager->flush();
        return $this->json("success",Response::HTTP_CREATED);

    }
}
