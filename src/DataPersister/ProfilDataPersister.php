<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Profil;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ProfilDataPersister  implements ContextAwareDataPersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var UserRepository
     */
    private UserRepository $user;


    /**
     * ProfilDataPersister constructor.
     */
    public function __construct(EntityManagerInterface $manager, UserRepository $user)
    {
        $this->manager=$manager;
        $this->user=$user;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Profil;
    }

    public function persist($data, array $context = [])
    {
       //dd($data);
        $data->setLibelle($data->getLibelle());
        $this->manager->persist($data);
        $this->manager->flush();
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setStatus(true);
        $id = $data->getId();
        $users =$this->user->findBy(['profil'=>$id]);
        foreach ($users as $user){
           $user->setStatus(true);
            $this->manager->persist($user);
            $this->manager->flush();
        }
        $this->manager->persist($data);
        $this->manager->flush();

        return new JsonResponse("Archivage successfully!",200,[],true);

    }
}