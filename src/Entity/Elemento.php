<?php

namespace App\Entity;

use App\Repository\ElementoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ElementoRepository::class)
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
     * @ORM\ManyToOne(targetEntity="Seccion", inversedBy="elementos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seccion;

    /**
     * @ORM\ManyToMany(targetEntity="Alergeno", cascade={"persist"})
     * @ORM\JoinColumn(name="Alergeno_id", referencedColumnName="id")
     */
    private $alergenos;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;

    /**
     * @ORM\Column(type="integer")
     */
    private $orden;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcion;

    public function __construct()
    {
        $this->seccion = new ArrayCollection();
        $this->alergenos = new ArrayCollection();
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

    /**
     * @return Collection|Alergeno[]
     */
    public function getAlergenos(): Collection
    {
        return $this->alergenos;
    }

    public function addAlergeno(Alergeno $alergeno): self
    {
        if (!$this->alergenos->contains($alergeno)) {
            $this->alergenos[] = $alergeno;
        }

        return $this;
    }

    public function removeAlergeno(Alergeno $alergeno): self
    {
        $this->alergenos->removeElement($alergeno);
        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function getOrden(): ?int
    {
        return $this->orden;
    }

    public function setOrden(int $orden): self
    {
        $this->orden = $orden;

        return $this;
    }
}
