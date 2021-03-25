<?php

namespace App\Entity;

use App\Repository\SeccionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SeccionRepository::class)
 * @ORM\Table(name="Seccion")
 */
class Seccion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nombre;

    /**
     * @ORM\OneToMany(targetEntity="Elemento", mappedBy="seccion")
     *
     */
    private $elementos;


    public function __construct()
    {
        $this->elementos = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getElementos(): ArrayCollection
    {
        return $this->elementos;
    }

    /**
     * @param ArrayCollection $elementos
     */
    public function setElementos(ArrayCollection $elementos): void
    {
        $this->elementos = $elementos;
    }



}
