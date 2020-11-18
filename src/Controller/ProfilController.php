<?php

namespace App\Controller;

use App\Repository\ProfilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    /**
     * @Route("api/admin/profils/{id}", name="lister_un_profils")
     */
    public function listerUnProfil(ProfilRepository $repo ,$id)
    {
        $profil = $repo->find($id);
        //dd($profil);
        return $this->json($profil, 200);
    }
}
