<?php

namespace Brocante\Bundle\BrocanteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Brocante\Bundle\BrocanteBundle\Entity\ReservationRepository")
 */
class Reservation
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
     * @ORM\OneToOne(targetEntity="Participant", inversedBy="reservation")
     * @ORM\JoinColumn(name="participant_id", referencedColumnName="id")
     */
    protected $participant;

    /**
     * @ORM\OneToMany(targetEntity="Emplacement", cascade={"all"}, mappedBy="reservation")
     */
    protected $emplacements;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_emplacements", type="integer", nullable=true)
     */
    private $nbEmplacements;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="paye", type="boolean")
     */
    private $paye;

    private $identifiant;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_wanted", type="boolean")
     */
    private $isWanted;

    public function __construct()
    {
        $this->setPaye( false );
        $this->setIsWanted( false );
        $this->setCreatedAt( new \Datetime() );
        $this->emplacements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getIdentifiant();
    }

    public function getIdentifiant()
    {
        $identifiant =  'RES-' . $this->getId() . '-';

        if (null != $this->getParticipant()) {
            $identifiant .= substr($this->getParticipant()->getPrenom(), 0, 3);
        }

        return $identifiant;
    }

    public function confirmPayment()
    {
        $this->setPaye( true );
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Reservation
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set paye
     *
     * @param boolean $paye
     * @return Reservation
     */
    public function setPaye($paye)
    {
        $this->paye = $paye;

        return $this;
    }

    /**
     * Get paye
     *
     * @return boolean 
     */
    public function getPaye()
    {
        return $this->paye;
    }

    /**
     * Set participant
     *
     * @param \Brocante\Bundle\BrocanteBundle\Entity\Participant $participant
     * @return Reservation
     */
    public function setParticipant(\Brocante\Bundle\BrocanteBundle\Entity\Participant $participant = null)
    {
        $this->participant = $participant;

        return $this;
    }

    /**
     * Get participant
     *
     * @return \Brocante\Bundle\BrocanteBundle\Entity\Participant 
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * Set isWanted
     *
     * @param boolean $isWanted
     * @return Reservation
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
     * Set nbEmplacements
     *
     * @param integer $nbEmplacements
     * @return Reservation
     */
    public function setNbEmplacements($nbEmplacements)
    {
        $this->nbEmplacements = $nbEmplacements;

        return $this;
    }

    /**
     * Get nbEmplacements
     *
     * @return integer 
     */
    public function getNbEmplacements()
    {
        return $this->nbEmplacements;
    }

    /**
     * Add emplacements
     *
     * @param \Brocante\Bundle\BrocanteBundle\Entity\Emplacement $emplacements
     * @return Reservation
     */
    public function addEmplacement(\Brocante\Bundle\BrocanteBundle\Entity\Emplacement $emplacements)
    {
        $this->emplacements[] = $emplacements;

        return $this;
    }

    /**
     * Remove emplacements
     *
     * @param \Brocante\Bundle\BrocanteBundle\Entity\Emplacement $emplacements
     */
    public function removeEmplacement(\Brocante\Bundle\BrocanteBundle\Entity\Emplacement $emplacements)
    {
        $this->emplacements->removeElement($emplacements);
    }

    /**
     * Get emplacements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmplacements()
    {
        return $this->emplacements;
    }
}
