<?php

namespace App\Entity;

use App\Repository\SeccionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icono;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(name="orden", type="integer")
     */
    private $orden;

    /**
     * @ORM\OneToMany(targetEntity="Elemento", mappedBy="seccion", orphanRemoval=true)
     * @var Collection
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
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection $elementos
     */
    public function getElementos(): Collection
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

    public function addElemento(Elemento $elemento): self
    {
        if (!$this->elementos->contains($elemento)) {
            $this->elementos[] = $elemento;
            $elemento->setSeccion($this);
        }

        return $this;
    }

    public function removeElemento(Elemento $elemento): self
    {
        if ($this->elementos->removeElement($elemento)) {
            // set the owning side to null (unless already changed)
            if ($elemento->getSeccion() === $this) {
                $elemento->setSeccion(null);
            }
        }

        return $this;
    }

    public function getIcono(): ?string
    {
        return $this->icono;
    }

    public function setIcono(?string $icono): self
    {
        $this->icono = $icono;

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
