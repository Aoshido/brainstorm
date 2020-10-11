<?php

namespace App\Entity;

use App\Repository\IdeaRepository;
use Doctrine\ORM\Mapping as ORM;

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

}
