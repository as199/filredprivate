<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\GroupeCompetence;
use App\Entity\Niveau;
use App\Repository\CompetenceRepository;
use App\Repository\GroupeCompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GroupeCompetenceController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var GroupeCompetenceRepository
     */
    private GroupeCompetenceRepository $grpecompetences;
    /**
     * @var CompetenceRepository
     */
    private CompetenceRepository $competenceRepository;
    /**
     * @var Request
     */
    private Request $request;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * GroupeCompetenceController constructor.
     */
    public function __construct(EntityManagerInterface $manager,GroupeCompetenceRepository $grpecompetences
        ,CompetenceRepository $competenceRepository,SerializerInterface $serializer)
    {
        $this->manager = $manager;
        $this->grpecompetences =$grpecompetences;
        $this->competenceRepository = $competenceRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Route(
     *     "/api/admin/grpecompetences/{id}",
     *      name="putGroupcompetence",
     *     methods={"PUT",},
     *     defaults={
     *      "_api_resource_class"=GroupeCompetence::class,
     *      "_api_item_operation_name"="updateCompetenceId"
     *     }
     *     )
     */
    public function updateCompetenceId(int $id,  Request $request )
    {
        //dd("eeeeeeeeeeeeeee");
        $groupecompetence= $this->grpecompetences->find($id);
        //dd($groupecompetence);
        $compObject= json_decode($request->getContent());
        if($compObject->option == "add")
        {
            if ($compObject->competences)
            {
                for ($i=0;$i<count($compObject->competences); $i++)
                {
                    //dd($compObject->competences);
                    if (isset($compObject->competences[$i]->id)){
                        $id =$compObject->competences[$i]->id;

                        $comp = $this->competenceRepository->findBy(['id'=>$id]);
                        $groupecompetence->addCompetence($comp[0]);
                        //dd($groupecompetence);
                    }else{
                        $competence = new Competence();
                        $competence->setLibelle($compObject->competences[$i]->libelle);
                        $groupecompetence->addCompetence($competence);
                        $this->manager->persist($competence);
                    }


                }

                $this->manager->flush();
                return $this->json('success');
            }
        }else{
            for ($i=0;$i<count($compObject->competences); $i++)
            {
                if (isset($compObject->competences[$i]->id)){
                    $comp = $this->competenceRepository->find($compObject->competences[$i]->id);
                    $groupecompetence->removeCompetence($comp);
                    $this->manager->flush();
                }
            }
        }
        return $this->json("edit");
    }

    /**
     * @Route(
     *     "/api/admin/grpecompetences",
     *      name="groupcompadd",
     *     methods={"POST",},
     *     defaults={
     *      "_api_resource_class"=GroupeCompetence::class,
     *      "_api_collection_operation_name"="AddGroupeCompetences"
     *     }
     *     )
     */
    public function AddGroupeCompetences( Request $request ){

        $compObject= $this->serializer->decode($request->getContent(),'json');

       //dd($compObject);
        foreach ($compObject['competence'] as $competence){
            //dd($competence['libelle']);
            if($this->competenceRepository->findOneBy(['libelle'=>$competence['libelle']])){
                $objCompetence =$this->competenceRepository->findOneBy(['libelle'=>$competence['libelle']]);
                $groupeCompetene = new GroupeCompetence();
                $groupeCompetene->setLibelle($compObject['libelle']);
                $groupeCompetene->setDescriptif($compObject['descriptif']);
                $groupeCompetene->setStatus(false);
                $groupeCompetene->addCompetence($objCompetence);
                $this->manager->persist($groupeCompetene);
            }else{
                if ($compObject['competence']){
                    $data = $compObject['competence'][0]['niveau'];
                        //dd(count($data));
                    if (count($data) == 2){
                        return new JsonResponse("Error please enter 3 levels!",400,[],true);
                    }else{
                        foreach ($compObject['competence'] as $objetCompetence){
                            $competence = new Competence();
                            $competence->setLibelle($objetCompetence['libelle']);

                            foreach ($data as $objetniveau){
                                //dd($objetniveau);
                                $niveau = new Niveau();
                                $niveau->setLibelle($objetniveau['libelle'])
                                    ->setCritereEvalution($objetniveau['critereEvalution'])
                                    ->setGroupeAction($objetniveau['groupeAction']);
                                $competence->addNiveau($niveau);
                                $this->manager->persist($niveau);

                            }
                            $this->manager->persist($competence);
                        }



                    }
                }else{
                    return new JsonResponse("Error please enter levels!",400,[],true);
                }
            }

            $this->manager->flush();
        }
        return $this->json("valider");

    }
}
