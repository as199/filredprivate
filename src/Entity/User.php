<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("username")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type_id", type="integer")
 * @ORM\DiscriminatorMap({1 ="Admin",2="Formateur", 3="Cm", 4="Apprenant", 5="User"})
 * @ApiResource(
 *     itemOperations={
 *     "get_user_id":{
 *           "method":"get",
 *          "path":"/admin/users/{id}",
 *              "access_control"="(is_granted('ROLE_ADMIN') )",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *              "deserialize" = false
 *          },"putUserId":{
 *           "method":"put",
 *          "path":"/admin/users/{id}",
 *              "access_control"="(is_granted('ROLE_ADMIN') )",
 *              "deserialize"= false,
 *          }},
 *     collectionOperations={
 *     "get":{
*              "path":"/admin/users",
 *              "access_control"="(is_granted('ROLE_ADMIN') )",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *              "deserialize" = false
 *          },
 *     "addUser":{
 *              "route_name"="adding",
 *              "path":"/admin/users",
 *               "access_control"="(is_granted('ROLE_ADMIN') )",
 *               "deserialize" = false
 *              }
 *
 *      }
 * )
 * @ApiFilter (SearchFilter::class, properties={"status": "exact"})
 */
class User implements UserInterface
{
    const GENRES = ['male', 'female'];
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
     * @Assert\NotBlank(message="please enter your username")
     * @Assert\Length(
     *     min = 4,
     * )
     */
    private $username;

    
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     *  @Assert\NotBlank(message="please enter your password")
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     */
    private $profil;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ({"admin_profil_id:read"})
     *  @Assert\NotBlank(groups={"postValidation"})
     */
    private $nomComplete;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ({"admin_profil_id:read"})
     * @Assert\NotBlank(message="please enter your address")
     *
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ({"admin_profil_id:read"})
     * @Assert\NotBlank(message="please enter your phoneNumber")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Groups ({"admin_profil_id:read"})
     * @Assert\NotBlank
     *  @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     * @Assert\NotBlank(message="please enter your E-mail")
     *
     */
    private $email;

    /**
     * @ORM\Column(type="boolean",  nullable=true)
     * * @Groups ({"admin_profil_id:read"})
     */
    private $status=1;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * * @Groups ({"admin_profil_id:read"})
     */
    private $avartar;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="please enter your gender")
     * @Assert\Choice(choices=User::GENRES, message="Choose a valid genre.")
     *
     */
    private $genre;

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

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAvartar()
    {   if ($this->avartar != null){
        return base64_encode(stream_get_contents($this->avartar));
        }else{
        return $this->avartar;
    }

    }

    public function setAvartar($avartar): self
    {
        $this->avartar = $avartar;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }
}
