<?php
namespace Brocante\Bundle\BrocanteBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;

use Brocante\Bundle\Brocante\Entity\Reservation;

class ReservationSendMailListener
{

    protected $em;

    public function postPersist(LifecycleEventArgs $args)
    {
        $reservation = $args->getEntity();
        $this->em = $args->getEntityManager();

        // Trigger listener only when user drink a beer
        if ($reservation instanceof Reservation) {
            
            $participant = $reservation->getParticipant();

            echo 'reservation';
            exit();
            
     
        }
    }

}