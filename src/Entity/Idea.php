<?php

namespace App\Entity;

use App\Repository\IdeaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=IdeaRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Idea {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 25,
     *      minMessage = "Title must be at least {{ limit }} characters long",
     *      maxMessage = "Title cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modificationDate;

    /**
     * Many ideas have one user. This is the owning side.
     * @ORM\ManyToOne(targetEntity="User", inversedBy="ideas")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\PrePersist
     */
    public function setCreationInformation() {
        $this->active = true;
        $this->creationDate = new \DateTime('now');
        $this->modificationDate = new \DateTime('now');
    }

    /**
     * @ORM\PreUpdate
     */
    public function setLastModificationDate() {
        $this->modificationDate = new \DateTime('now');
    }

    function getId() {
        return $this->id;
    }

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }

    function getCreationDate() {
        return $this->creationDate;
    }

    function getModificationDate() {
        return $this->modificationDate;
    }

    function getActive() {
        return $this->active;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    function setModificationDate($modificationDate) {
        $this->modificationDate = $modificationDate;
    }

    function setActive($active) {
        $this->active = $active;
    }

    /**
     * 
     * @return User
     */
    function getUser() {
        return $this->user;
    }

    function setUser(User $user) {
        $this->user = $user;
    }

}
