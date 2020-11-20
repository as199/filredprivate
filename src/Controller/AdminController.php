<?php

namespace App\Controller;


use App\Entity\Admin;
use App\Entity\User;
use App\Service\InscriptionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AdminController extends AbstractController
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
     * AdminController constructor.
     */
    public function __construct(EntityManagerInterface $manager,SerializerInterface $serializer)
    {
        $this->manager = $manager;
        $this->serializer = $serializer;
    }

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
    public function AddUser(InscriptionService $service, Request $request)
    {
        $utilisateur = $service->NewUser("Admin",$request);
        $this->manager->persist($utilisateur);
        $this->manager->flush();
        return new JsonResponse("success",200,[],true);

    }

    /**
     * @Route(
     *     "api/admin/users/{id}",
     *      name="putUserId",
     *     methods={"PUT"},
     *     defaults={
     *      "_api_resource_class"=User::class,
     *      "_api_item_operation_name"="putUserId"
     *     }
     *     )
     */
    public function putUserId(InscriptionService $service, Request $request)
    {
        $userUpdate = $service->PutUtilisateur($request,'avartar');
        $utilisateur = $request ->attributes->get('data');
       //dd($userUpdate);
       foreach ($userUpdate as $key=> $valeur){
           $setter = 'set'. ucfirst(strtolower($key));
           //dd($setter);
           if(method_exists(Admin::class, $setter)){
            $utilisateur->$setter($valeur);
           }
       }
       $this->manager->persist($utilisateur);
       $this->manager->flush();

        return new JsonResponse("success",200,[],true);


    }
}
