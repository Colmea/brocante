<?php

namespace Brocante\Bundle\BrocanteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emplacement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Brocante\Bundle\BrocanteBundle\Entity\EmplacementRepository")
 */
class Emplacement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Reservation", inversedBy="emplacements")
     * @ORM\JoinColumn(name="reservation_id", referencedColumnName="id", nullable=true)
     */
    protected $reservation;

    /**
     * @ORM\ManyToOne(targetEntity="Zone", inversedBy="emplacements")
     * @ORM\JoinColumn(name="zone_id", referencedColumnName="id")
     */
    protected $zone;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=20)
     */
    private $numero;

    /**
     * @var integer
     *
     * @ORM\Column(name="surface", type="integer")
     */
    private $surface;

    /**
     * @var string
     *
     * @ORM\Column(name="remarque", type="text", nullable=true)
     */
    private $remarque;


    public function __toString()
    {
        return $this->getIdentifiant();
    }

    public function getIdentifiant()
    {
       $output = $this->getZone() . '-' . $this->getNumero();
       if ( !$this->isFree() )
        $output .= ' [RESERVE]';

        return $output;
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
     * Set zone
     *
     * @param string $zone
     * @return Emplacement
     */
    public function setZone($zone)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return string 
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return Emplacement
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set surface
     *
     * @param integer $surface
     * @return Emplacement
     */
    public function setSurface($surface)
    {
        $this->surface = $surface;

        return $this;
    }

    /**
     * Get surface
     *
     * @return integer 
     */
    public function getSurface()
    {
        return $this->surface;
    }

    /**
     * Set remarque
     *
     * @param string $remarque
     * @return Emplacement
     */
    public function setRemarque($remarque)
    {
        $this->remarque = $remarque;

        return $this;
    }

    /**
     * Get remarque
     *
     * @return string 
     */
    public function getRemarque()
    {
        return $this->remarque;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Détermine si l'emplacement est toujours libre ou non
     */
    public function isFree()
    {
        return  ( is_null($this->reservation) );
    }

    /**
     * Set reservation
     *
     * @param \Brocante\Bundle\BrocanteBundle\Entity\Reservation $reservation
     * @return Emplacement
     */
    public function setReservation(\Brocante\Bundle\BrocanteBundle\Entity\Reservation $reservation = null)
    {
        $this->reservation = $reservation;

        return $this;
    }

    /**
     * Get reservation
     *
     * @return \Brocante\Bundle\BrocanteBundle\Entity\Reservation 
     */
    public function getReservation()
    {
        return $this->reservation;
    }
}
