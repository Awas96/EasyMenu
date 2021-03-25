<?php

namespace App\Entity;

use App\Repository\AlergenoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlergenoRepository::class)
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

    /**
     * @ORM\ManyToMany(targetEntity="Elemento", mappedBy="alergenos")
     */
    private $elementos;


    public function __construct()
    {
        $this->elementos =  new ArrayCollection();
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
}
