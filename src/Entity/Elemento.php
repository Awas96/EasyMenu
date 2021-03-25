<?php

namespace App\Entity;

use App\Repository\EntidadRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntidadRepository::class)
 * @ORM\Table(name="Elemento")
 */
class Elemento
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
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $precio;

    /**
     * @ORM\ManyToOne(targetEntity="Seccion", inversedBy="elementos"
     * @ORM\JoinColumn(nullable=false)
     */
    private $seccion;

    /**
     * @ORM\ManyToMany(targetEntity="Alergeno", inversedBy="elementos")
     * @joinTable(name="elementos_alergenos")
     */
    private $alergenos;


    public function __construct()
    {
        $this->seccion =  new ArrayCollection();
        $this->alergenos =  new ArrayCollection();
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

    public function getPrecio(): ?string
    {
        return $this->precio;
    }

    public function setPrecio(?string $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeccion()
    {
        return $this->seccion;
    }

    /**
     * @param mixed $seccion
     */
    public function setSeccion($seccion): void
    {
        $this->seccion = $seccion;
    }
}
