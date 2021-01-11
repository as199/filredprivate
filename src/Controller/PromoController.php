<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\Promo;
use App\Repository\ApprenantRepository;
use App\Repository\ProfilRepository;
use App\Repository\PromoRepository;
use App\Service\GestionImage;
use App\Service\PromoService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PromoController extends AbstractController
{
    /**
     * @var PromoRepository
     */
    private PromoRepository $promoReposity;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var GestionImage
     */
    private GestionImage $gestionImage;
    /**
     * @var ApprenantRepository
     */
    private ApprenantRepository $apprenantReposity;
    /**
     * @var ProfilRepository
     */
    private ProfilRepository $profilRepository;


    /**
     * PromoController constructor.
     */
    public function __construct(
        GestionImage $gestionImage,ProfilRepository $profilRepository, EntityManagerInterface $manager,PromoRepository $promoRepository,ApprenantRepository $apprenantReposity
    )
    {
        $this->gestionImage = $gestionImage;
        $this->manager = $manager;
        $this->promoReposity = $promoRepository;
        $this->apprenantReposity = $apprenantReposity;
        $this->profilRepository =$profilRepository;
    }

    public function EditPromo()
    {
       dd("salut");
    }


    public function AddPromo(Request $request,PromoService $promoService): JsonResponse
    {
        $promoreq = $request->request->all();

        $myPromo = new Promo();
        if( $request->files->get('upload')){

            $file= $request->files->get('upload');
            $user = $promoService->uploadExcel($file);
           $users = $promoService->toArray($user);
           //dd($users);
           for ($p =0; $p < count($users); $p++){
               if ($users[$p]['email']){
                   if( $this->apprenantReposity->findOneBy(['email'=>$users[$p]['email']])){
                       $myPromo->addApprenant( $this->apprenantReposity->findOneBy(['email'=>$users[$p]['email']]));
                   }else{
                       $apprenant = new Apprenant();
                       $apprenant->setNomComplete('null')
                           ->setUsername($users[$p]['email'])
                           ->setPassword('passer123')
                           ->setAdresse('null')
                           ->setEmail($users[$p]['email'])
                           ->setGenre('null')
                           ->setProfil($this->profilRepository->findOneBy(['libelle'=>'Apprenant']))
                           ->setTelephone('');
                       $this->manager->persist($apprenant);
                       $myPromo->addApprenant($apprenant);
                   }
               }

           }

        }

        if( $request->files->get('avatar')){
            $avatar= $request->files->get('avatar');
            $avatar = fopen($avatar->getRealPath(),'r+');
            $myPromo->setAvatar($avatar);
        }
        foreach ($promoreq as $key=> $valeur){
            $setter = 'set'. ucfirst(strtolower($key));
            //dd($setter);
            if(method_exists(Promo::class, $setter)){
                if ($key=='dateFinProvisoire'){
                    try {
                        $dateFinP = new DateTime($promoreq['dateFinProvisoire']);
                        $myPromo->setDateFinProvisoire($dateFinP);
                    } catch (\Exception $e) {

                    }
                }elseif ($key=='dateFinReel'){
                    try {
                        $dateFinR = new DateTime($promoreq['dateFinReel']);
                        $myPromo->setDateFinReel($dateFinR);

                    } catch (\Exception $e) {

                    }
                }
                else{
                        $myPromo->$setter($valeur);

                }


            }

        }


        if(isset($promoreq['apprenants'])){
            $array = explode(',',$promoreq['apprenants']);
            //dd($array);
            for ($i=0;$i< count($array)-1;$i++){
               // dd($this->apprenantReposity->findOneBy(['email'=>$array[$i]]));
                if( $this->apprenantReposity->findOneBy(['email'=>$array[$i]])){

                    $myPromo->addApprenant( $this->apprenantReposity->findOneBy(['email'=>$array[$i]]));
                }
            }
        }

        $this->manager->persist($myPromo);
        $this->manager->flush();
        return new JsonResponse("success",200,[],true);

    }
}
