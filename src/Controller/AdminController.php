<?php

namespace App\Controller;



use App\Entity\Admin;
use App\Entity\User;
use App\Service\InscriptionService;
use App\Service\SendEmail;
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
     * @var SendEmail
     */
    private SendEmail $sendEmail;

    /**
     * AdminController constructor.
     */
    public function __construct(EntityManagerInterface $manager,SerializerInterface $serializer,SendEmail $sendEmail)
    {
        $this->manager = $manager;
        $this->serializer = $serializer;
        $this->sendEmail = $sendEmail;
    }

    /**
     * @Route(
     *     "api/admin/users",
     *      name="adding",
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
        if (!empty($service->ValidatePost($utilisateur))){
            return $this->json($service->ValidatePost($utilisateur),400);
        }
        $this->manager->persist($utilisateur);
        $this->manager->flush();
        $this->sendEmail->send($utilisateur->getEmail(),"registration",'your registration has been successfully completed');
        /*$utilisateur->setAvartar(stream_get_contents($utilisateur['avartar']));
        $userTr=$this->serializer->serialize($utilisateur,'json');*/
        return $this->json($utilisateur,200);
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