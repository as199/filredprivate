<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\User;
use App\Service\InscriptionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ApprenantController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    /**
     * ApprenantController constructor.
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager=$manager;
    }

    /**
     * @Route(
     *     "api/apprenants",
     *      name="addApprenant",
     *     methods={"POST"},
     *     defaults={
     *      "_api_resource_class"=Apprenant::class,
     *      "_api_collection_operation_name"="addApprenant"
     *     }
     *     )
     */
    public function addApprenant(InscriptionService $service,Request $request)
    {

        $utilisateur = $service->NewUser("Apprenant",$request);
        $this->manager->persist($utilisateur);
        $this->manager->flush();
        return new JsonResponse("success",200,[],true);

    }
}
