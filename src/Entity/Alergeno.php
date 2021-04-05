<?php

namespace App\Entity;

use App\Repository\AlergenoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlergenoRepository::class)
 * @ORM\Table(name="Alergeno")
 */
class Alergeno
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
    private $nombre;

    /**
     * @ORM\Column(type="text")
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imgRuta;



    public function __construct()
    {
        $this->elementos = new ArrayCollection();
    }

    public function __toString()
    {
       return "alergenos!";
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getImgRuta(): ?string
    {
        return $this->imgRuta;
    }

    public function setImgRuta(string $imgRuta): self
    {
        $this->imgRuta = $imgRuta;

        return $this;
    }

    /**
     * @return Collection|Elemento[]
     */
    public function getElementos(): Collection
    {
        return $this->elementos;
    }

    public function addElemento(Elemento $elemento): self
    {
        if (!$this->elementos->contains($elemento)) {
            $this->elementos[] = $elemento;
            $elemento->addAlergeno($this);
        }

        return $this;
    }

    public function removeElemento(Elemento $elemento): self
    {
        if ($this->elementos->removeElement($elemento)) {
            $elemento->removeAlergeno($this);
        }

        return $this;
    }
}
