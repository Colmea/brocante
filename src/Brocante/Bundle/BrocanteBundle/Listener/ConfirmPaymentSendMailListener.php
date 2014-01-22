<?php
namespace Brocante\Bundle\BrocanteBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;

use Brocante\Bundle\BrocanteBundle\Entity\Reservation;

class ConfirmPaymentSendMailListener
{

    protected $em;

    /** @var $mailer \Swift_Mailer **/
    protected $mailer;

    protected $template;

    /** @var string $webRoot */
    protected $webRoot;

    public function __construct( $rootDir )
    {
        $this->webRoot = realpath($rootDir . '/../web');
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $reservation = $args->getEntity();
        $this->em = $args->getEntityManager();

        // Vérifie qu'il s'agit bien d'une Réservation
        if ($reservation instanceof Reservation)
        {
            // N'envoie le mail que si paiement vient d'être confirmé
            // Evite de renvoyer e-mail si la réservation était déjà confirmée avant
            if ($args->hasChangedField('paye')
                && $args->getOldValue('paye') == false
                && $args->getNewValue('paye') == true
                )
            {
                
                // Crée mail de confirmation
                $message = \Swift_Message::newInstance()
                    ->setContentType("text/html")
                    ->setCharset('utf-8')
                    ->setSubject('Brocante Heusy: paiement confirmé')
                    ->setFrom('brocanteheusy2014@gmail.com')
                    ->setTo( $reservation->getParticipant()->getEmail() )

                    ->setBody($this->template->renderResponse('BrocanteBrocanteBundle:Reservation:mail_confirmation_paiement.html.twig', array(
                        'participant' => $reservation->getParticipant(),
                        'prix' => 8.5 * $reservation->getNbEmplacements()

                    )))
                ;

                // Attache le règlement
                $message->attach(\Swift_Attachment::fromPath($this->webRoot . '/documentation/Reglement_brocante_heusy_2014.pdf' ));

                $this->mailer->send($message);
            }

        }

    }

    public function setMailer(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function setTemplate($templating)
    {
        $this->template = $templating;
    }

}