<?php
namespace Brocante\Bundle\BrocanteBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ParticipantAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('prenom')
            ->add('nom')
            ->add('email')
            ->add('telephone', null, array('required' => false))
            ->with('Reservation')
                ->add('reservation', 'sonata_type_admin', array('delete' => false))
            ->end()
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('prenom')
            ->add('nom')
            ->add('email')
            ->add('reservation.paye', null, array('label' => 'Payé ?'))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('prenom')
            ->add('nom')
            ->add('email')
            ->add('reservation.nbEmplacements', null, array('label' => 'Emplacements'))
            ->add('reservation.paye', null, array('label' => 'A payé ?'))
        ;
    }

    public function prePersist($participant)
    {
        $reservation = $participant->getReservation();
        $reservation->setParticipant( $participant );
    }

    public function preUpdate($participant)
    {
        $reservation = $participant->getReservation();
        $reservation->setParticipant( $participant );

        $participant->setReservation( $reservation );
    }
 
}