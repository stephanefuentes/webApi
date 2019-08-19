<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Film
 *
 * @ORM\Table(name="film")
 * @ORM\Entity
 */
class Film
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSortie", type="date", nullable=false)
     */
    private $datesortie;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Acteur", inversedBy="film")
     * @ORM\JoinTable(name="films_acteurs",
     *   joinColumns={
     *     @ORM\JoinColumn(name="film_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="acteur_id", referencedColumnName="id")
     *   }
     * )
     */
    private $acteur;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="film")
     * @ORM\JoinTable(name="films_genres",
     *   joinColumns={
     *     @ORM\JoinColumn(name="film_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="genre_id", referencedColumnName="id")
     *   }
     * )
     */
    private $genre;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Realisateur", inversedBy="film")
     * @ORM\JoinTable(name="films_realisateurs",
     *   joinColumns={
     *     @ORM\JoinColumn(name="film_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="realisateur_id", referencedColumnName="id")
     *   }
     * )
     */
    private $realisateur;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->acteur = new \Doctrine\Common\Collections\ArrayCollection();
        $this->genre = new \Doctrine\Common\Collections\ArrayCollection();
        $this->realisateur = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Film
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set datesortie
     *
     * @param \DateTime $datesortie
     *
     * @return Film
     */
    public function setDatesortie($datesortie)
    {
        $this->datesortie = $datesortie;

        return $this;
    }

    /**
     * Get datesortie
     *
     * @return \DateTime
     */
    public function getDatesortie()
    {
        return $this->datesortie;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Film
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add acteur
     *
     * @param \AppBundle\Entity\Acteur $acteur
     *
     * @return Film
     */
    public function addActeur(\AppBundle\Entity\Acteur $acteur)
    {
        $this->acteur[] = $acteur;

        return $this;
    }

    /**
     * Remove acteur
     *
     * @param \AppBundle\Entity\Acteur $acteur
     */
    public function removeActeur(\AppBundle\Entity\Acteur $acteur)
    {
        $this->acteur->removeElement($acteur);
    }

    /**
     * Get acteur
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActeur()
    {
        return $this->acteur;
    }

    /**
     * Add genre
     *
     * @param \AppBundle\Entity\Genre $genre
     *
     * @return Film
     */
    public function addGenre(\AppBundle\Entity\Genre $genre)
    {
        $this->genre[] = $genre;

        return $this;
    }

    /**
     * Remove genre
     *
     * @param \AppBundle\Entity\Genre $genre
     */
    public function removeGenre(\AppBundle\Entity\Genre $genre)
    {
        $this->genre->removeElement($genre);
    }

    /**
     * Get genre
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Add realisateur
     *
     * @param \AppBundle\Entity\Realisateur $realisateur
     *
     * @return Film
     */
    public function addRealisateur(\AppBundle\Entity\Realisateur $realisateur)
    {
        $this->realisateur[] = $realisateur;

        return $this;
    }

    /**
     * Remove realisateur
     *
     * @param \AppBundle\Entity\Realisateur $realisateur
     */
    public function removeRealisateur(\AppBundle\Entity\Realisateur $realisateur)
    {
        $this->realisateur->removeElement($realisateur);
    }

    /**
     * Get realisateur
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRealisateur()
    {
        return $this->realisateur;
    }
}
