<?php

namespace Brocante\Bundle\BrocanteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReservationEmplacement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Brocante\Bundle\BrocanteBundle\Entity\ReservationEmplacementRepository")
 */
class ReservationEmplacement
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
     * @ORM\JoinColumn(name="reservation_id", referencedColumnName="id")
     */
    protected $reservation;

    /**
     * @ORM\OneToOne(targetEntity="Emplacement", inversedBy="reservation")
     * @ORM\JoinColumn(name="emplacement_id", referencedColumnName="id")
     */
    protected $emplacement;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_wanted", type="boolean")
     */
    private $isWanted;


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
     * Set isWanted
     *
     * @param boolean $isWanted
     * @return ReservationEmplacement
     */
    public function setIsWanted($isWanted)
    {
        $this->isWanted = $isWanted;

        return $this;
    }

    /**
     * Get isWanted
     *
     * @return boolean 
     */
    public function getIsWanted()
    {
        return $this->isWanted;
    }

    /**
     * Set reservation
     *
     * @param \Brocante\Bundle\BrocanteBundle\Entity\Reservation $reservation
     * @return ReservationEmplacement
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

    /**
     * Set emplacement
     *
     * @param \Brocante\Bundle\BrocanteBundle\Entity\Emplacement $emplacement
     * @return ReservationEmplacement
     */
    public function setEmplacement(\Brocante\Bundle\BrocanteBundle\Entity\Emplacement $emplacement = null)
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    /**
     * Get emplacement
     *
     * @return \Brocante\Bundle\BrocanteBundle\Entity\Emplacement 
     */
    public function getEmplacement()
    {
        return $this->emplacement;
    }
}
