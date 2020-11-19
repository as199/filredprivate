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
 *                      "path":"/formateurs/{id}",
 *                       "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *                       "access_control_message"="Vous n'avez pas access à cette Ressource",
 *
 *                    },
 *                  "put_formateur_id":{
 *                       "method":"put",
 *                      "path":"/formateurs/{id}",
 *                       "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *                       "access_control_message"="Vous n'avez pas access à cette Ressource",
 *
 *                    }
*               },
 *     collectionOperations={
 *          "get":{
 *              "path":"/formateurs",
 *              "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')or is_granted('ROLE_CM') )",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *               },
 *      }
 *     )
 */
class Formateur extends User
{
    
}
