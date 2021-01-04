<?php

namespace App\Controller;
use App\Entity\Competence;
use App\Entity\Niveau;
use App\Repository\CompetenceRepository;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CompetenceController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var CompetenceRepository
     */
    private CompetenceRepository $competenceRepository;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;
    /**
     * @var NiveauRepository
     */
    private NiveauRepository $niveauRepository;

    public function __construct(EntityManagerInterface $manager, CompetenceRepository $competenceRepository, SerializerInterface $serializer,NiveauRepository $niveauRepository)
    {
        $this->manager = $manager;
        $this->competenceRepository = $competenceRepository;
        $this->serializer = $serializer;
        $this->niveauRepository =$niveauRepository;
    }
    /**
     * @Route(
     *     "api/admin/competences/{id}",
     *      name="PutCompetence",
     *     methods={"PUT"},
     *     defaults={
     *      "_api_resource_class"=Competence::class,
     *      "_api_item_operation_name"="updateCompetences"
     *     }
     *     )
     */
    public function updateCompetence(Request $request ,$id)
    {
        $request = $request->getContent();
        //dd($request);

        $competences = $this->manager->getRepository(Competence::class)->find($id);

        $tabCompetences = $this->serializer->decode($request, 'json');

        if (isset($tabCompetences['libelle']) && !empty($tabCompetences['libelle']))
        {
            $competences->setLibelle($tabCompetences['libelle']);

        }

        if (isset($tabCompetences['niveau']))
//        dd($tabCompetences['niveau']);
        {
            foreach ($tabCompetences['niveau'] as $niveau)
            {
                if ($this->manager->getRepository(Niveau::class)->find($niveau['id'])){
                    $newNiveau = $this->manager->getRepository(Niveau::class)->find($niveau['id']);
                    $newNiveau->setLibelle($niveau['libelle'])
                        ->setCritereEvalution($niveau['critereEvalution'])
                        ->setGroupeAction($niveau['groupeAction']);
                    $this->manager->persist($newNiveau);
                }

            }
        }

        $this->manager->persist($competences);
        $this->manager->flush();

        return $this->json('Success');

    }
}
