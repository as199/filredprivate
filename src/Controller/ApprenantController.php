<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Service\GestionImage;
use App\Service\SendEmail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApprenantController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;
    /**
     * @var SendEmail
     */
    private SendEmail $sendEmail;

    /**
     * ApprenantController constructor.
     */
    public function __construct(EntityManagerInterface $manager,SerializerInterface $serializer,SendEmail $sendEmail)
    {
        $this->manager=$manager;
        $this->serializer=$serializer;
        $this->sendEmail=$sendEmail;
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
    public function addApprenant(GestionImage $service, Request $request)
    {

        $utilisateur = $service->NewUser("Apprenant",$request);
        //dd($utilisateur);
        if (!empty($service->ValidatePost($utilisateur))){
            return $this->json($service->ValidatePost($utilisateur),400);
        }
        $this->manager->persist($utilisateur);
        $this->manager->flush();
        $this->sendEmail->send($utilisateur->getEmail(),"registration",'your registration has been successfully completed');

        return new JsonResponse("success",200,[],true);

    }
}
