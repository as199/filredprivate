<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class AdminController extends AbstractController
{
    /**
     * @Route(
     *     "api/admin/users",
     *      name="addUser",
     *     methods={"POST"},
     *     defaults={
     *      "_api_resource_class"=User::class,
     *      "_api_collection_operation_name"="addUser"
     *     }
     *     )
     */
    public function AddUser(EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, Request $request,SerializerInterface $serializer)
    {

        $userReq = $request->request->all();
        $file = $request->files->get('avartar')->getRealPath();
        $avartar = fopen($file,'r+');
        $userReq['avartar']=$avartar;
        $newUser = $serializer->denormalize($userReq, Admin::class);
        $newUser->setPassword($encoder->encodePassword($newUser,$userReq['password']));
        $manager->persist($newUser);
        $manager->flush();
        return new JsonResponse("success",200,[],true);

    }
}
