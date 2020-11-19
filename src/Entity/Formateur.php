<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FormateurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 * @ApiResource (itemOperations={
 *                  "get_formateur_id":{
*                       "method":"get",
 *                      "path":"/formateur/{id}",
 *                      "normalization_context"={"groups":"admin_profil:read"},
 *                       "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *                       "access_control_message"="Vous n'avez pas access à cette Ressource",
 *
 *                    }
*               }
 *     )
 */
class Formateur extends User
{
    
}
