<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApprenantRepository", repositoryClass=ApprenantRepository::class)
 * @ApiResource(attributes={"pagination_enabled"=true},
 *     itemOperations={
 *     "get_apprenant_id":{
 *           "method":"get",
 *          "path":"/apprenants/{id}",
 *              "access_control"="(is_granted('ROLE_ADMIN')  or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_APPRENANT'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *          },"put_apprenant_id":{
 *           "method":"put",
 *          "path":"/apprenants/{id}",
 *              "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_APPRENANT'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *          }},
 *     collectionOperations={
 *     "get":{
 *              "path":"/apprenants",
 *              "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')or is_granted('ROLE_CM') )",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *              "deserialize" = false
 *          },
 *     "addApprenant":{"method":"post",
 *              "path":"/apprenants",
 *               "deserialize" = false
 *              }
 *
 *      }
 * )
 */
class Apprenant extends User
{

}
