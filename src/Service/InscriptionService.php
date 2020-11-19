<?php


namespace App\Service;


use App\Entity\Admin;
use App\Entity\Apprenant;
use App\Entity\Cm;
use App\Entity\Formateur;
use App\Entity\User;
use App\Repository\ProfilRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class InscriptionService
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;
    /**
     * @var ProfilRepository
     */
    private ProfilRepository $profilRepository;

    /**
     * InscriptionService constructor.
     */
    public function __construct(UserPasswordEncoderInterface $encoder,SerializerInterface $serializer,ProfilRepository $profilRepository )
    {
        $this->encoder =$encoder;
        $this->serializer = $serializer;
        $this->profilRepository = $profilRepository;
    }
    public function NewUser($profil, Request $request){
        $userReq = $request->request->all();
        $uploadedFile = $request->files->get('avartar');
        if($uploadedFile){
            $file = $uploadedFile->getRealPath();
            $avartar = fopen($file,'r+');
            $userReq['avartar']=$avartar;
        }
        if($profil == "Admin"){
            $user = Admin::class;
        }elseif ($profil == "Apprenant"){
            $user =Apprenant::class;
        }elseif ($profil == "Formateur"){
            $user =Formateur::class;
        }elseif ($profil == "Cm"){
            $user =Cm::class;
        }else{
            $user = User::class;
        }
        $newUser = $this->serializer->denormalize($userReq, $user);
        $newUser->setProfil($this->profilRepository->findOneBy(['libelle'=>$profil]));
        $newUser->setPassword($this->encoder->encodePassword($newUser,$userReq['password']));

        return $newUser;
    }
}