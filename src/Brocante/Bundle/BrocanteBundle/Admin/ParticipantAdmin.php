<?php
namespace Brocante\Bundle\BrocanteBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ParticipantAdmin extends Admin
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    protected $template;


    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('prenom')
            ->add('nom')
            ->add('email', 'email', array('required' => false) )
            ->add('telephone', null, array('required' => false))
            ->add('adresse', null, array('required' => false))
            ->with('Reservation')
                ->add('reservation', 'sonata_type_admin', array('delete' => true))
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
            ->add('reservation.nbEmplacements', null, array('label' => 'Nbr emplacements'))
            ->add('reservation.emplacements', null, array('label' => 'Emplacements choisis'))
            ->add('reservation.paye', null, array('label' => 'A payé ?'))
        ;
    }

    public function setMailer(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function setTemplate2($templating)
    {
        $this->template = $templating;
    }

    public function prePersist($participant)
    {
        $reservation = $participant->getReservation();
        $reservation->setParticipant( $participant );

        $emplacements = $reservation->getEmplacements();
        foreach ( $emplacements as $emplacement ) {
            $emplacement->setReservation($reservation);
        }
    }

    public function postPersist($participant)
    {
        $reservation = $participant->getReservation();

        if ( !is_null($reservation) && !is_null($participant->getEmail()) )
        {

            $message = \Swift_Message::newInstance()
                ->setContentType("text/html")
                ->setCharset('utf-8')
                ->setSubject('Brocante Heusy: confirmation de réservation')
                ->setFrom('brocante@heusy.org')
                ->setTo( $participant->getEmail() )

                ->setBody($this->template->renderResponse('BrocanteBrocanteBundle:Reservation:mail_confirmation.html.twig', array(
                    'participant' => $participant,
                    'prix' => 8.5 * $reservation->getNbEmplacements()

                )))
            ;

            $this->mailer->send($message);
        }


    }

    public function preUpdate($participant)
    {
        $reservation = $participant->getReservation();
        $reservation->setParticipant( $participant );

        $participant->setReservation( $reservation );

        $emplacements = $reservation->getEmplacements();
        foreach ( $emplacements as $emplacement ) {
            $emplacement->setReservation($reservation);
        }
    }


}