<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type_id", type="integer")
 * @ORM\DiscriminatorMap({1 ="Admin",2="Formateur", 3="Cm", 4="Apprenant", "user"="User"})
 * @ApiResource(attributes={"pagination_enabled"=true},
 *     itemOperations={
 *     "get_user_id":{
 *           "method":"get",
 *          "path":"/admin/users/{id}",
 *              "access_control"="(is_granted('ROLE_ADMIN') )",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *              "deserialize" = false
 *          },"put_user_id":{
 *           "method":"put",
 *          "path":"/admin/users/{id}",
 *              "access_control"="(is_granted('ROLE_ADMIN') )",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *          }},
 *     collectionOperations={
 *     "get":{
*              "path":"/admin/users",
 *              "access_control"="(is_granted('ROLE_ADMIN') )",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *              "deserialize" = false
 *          },
 *     "addUser":{"method":"post",
 *              "path":"/admin/users",
 *               "access_control"="(is_granted('ROLE_ADMIN') )",
 *               "deserialize" = false
 *              }
 *
 *      }
 * )
 *
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ({"admin_profil_id:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups ({"admin_profil_id:read"})
     *
     */
    private $username;

    
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     */
    private $profil;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ({"admin_profil_id:read"})
     */
    private $nomComplete;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ({"admin_profil_id:read"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ({"admin_profil_id:read"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $avartar;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
    $roles = $this->roles;
    // guarantee every user at least has ROLE_USER
    $roles[] = 'ROLE_'.$this->profil->getLibelle();

    return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getNomComplete(): ?string
    {
        return $this->nomComplete;
    }

    public function setNomComplete(string $nomComplete): self
    {
        $this->nomComplete = $nomComplete;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAvartar()
    {
        return $this->avartar;
    }

    public function setAvartar($avartar): self
    {
        $this->avartar = $avartar;

        return $this;
    }
}
