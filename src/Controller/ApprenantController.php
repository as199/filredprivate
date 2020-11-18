<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\User;
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
     * @Route(
     *     "api/apprenants",
     *      name="addApprenant",
     *     methods={"POST"},
     *     @IsGranted("ROLE_ADMIN")
     *     defaults={
     *      "_api_resource_class"=Apprenant::class,
     *      "_api_collection_operation_name"="addApprenant"
     *     }
     *     )
     */
    public function addApprenant(EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, Request $request,SerializerInterface $serializer)
    {

        $userReq = $request->request->all();
        $file = $request->files->get('avartar')->getRealPath();
        $avartar = fopen($file,'r+');
        $userReq['avartar']=$avartar;
        $newUser = $serializer->denormalize($userReq, Apprenant::class);
        $newUser->setPassword($encoder->encodePassword($newUser,$userReq['password']));
        $newUser->setRoles(['ROLE_USER']);

        $manager->persist($newUser);
        $manager->flush();
        return new JsonResponse("success",200,[],true);

    }
}
