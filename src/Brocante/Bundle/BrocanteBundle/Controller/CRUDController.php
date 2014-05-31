<?php

namespace Brocante\Bundle\BrocanteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sonata\AdminBundle\Controller\CRUDController as SonataCRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CRUDController extends SonataCRUDController
{
    public function indexAction($name)
    {
        return $this->render('BrocanteBrocanteBundle:Default:index.html.twig', array('name' => $name));
    }

	public function batchActionPaye($selectedModelQuery)
	{
		
	 	$request = $this->get('request');
	    $em = $this->getDoctrine()->getManager();

	    $nbParticipants = count($request->get('idx'));

	    // Pour chaque participant renseigné dans l'action
	    try
	    {
		    foreach ( $request->get('idx') as $idParticipant )
		    {
		    	$participant = $em->getRepository('BrocanteBrocanteBundle:Participant')->find( $idParticipant );
		    	
		    	// Si réservation présente
		    	if ( !is_null($participant->getReservation()) )
		    	{
		    		$participant->getReservation()->confirmPayment();
		    	}
		    }

		    $em->flush();

		} catch (\Exception $e) {
			// Si exception durant transaction
	        $this->addFlash('sonata_flash_error', 'Erreur lors de la confirmation du paiement. Veuillez réessayer');

	        return new RedirectResponse(
	          $this->admin->generateUrl('list',$this->admin->getFilterParameters())
	        );
    	}

    	if ( $nbParticipants > 1 )
    		$message = "<strong>{$nbParticipants}</strong> paiements confirmés. Un e-mail de confirmation a été envoyé aux participants";
    	else
    		$message = "<strong>1</strong> paiement confirmé. Un e-mail de confirmation a été envoyé au participant.";

		// Si tout s'est bien passé
	    $this->addFlash('sonata_flash_success', $message);

	    return new RedirectResponse(
	      $this->admin->generateUrl('list',$this->admin->getFilterParameters())
	    );
	}

	public function batchActionSendReservationMail($selectedModelQuery)
	{
		
	 	$request = $this->get('request');
	    $em = $this->getDoctrine()->getManager();

	    $nbParticipants = count($request->get('idx'));

	    // Pour chaque participant renseigné dans l'action
	    try
	    {
		    foreach ( $request->get('idx') as $idParticipant )
		    {
		    	$participant = $em->getRepository('BrocanteBrocanteBundle:Participant')->find( $idParticipant );
		    	
		    	// Si réservation présente
		    	if (is_null($participant->getReservation())) {
		    		continue;
		    	}

	    		$templating = $this->get('templating');

                // Crée mail de réservation
                $message = \Swift_Message::newInstance()
                    ->setContentType("text/html")
                    ->setCharset('utf-8')
                    ->setSubject('Brocante Heusy: Votre réservation (important !)')
                    ->setFrom('brocante@heusy.org')
                    ->setTo( $reservation->getParticipant()->getEmail() )


                    ->setBody($templating->renderResponse('BrocanteBrocanteBundle:Reservation:mail_reservation.html.twig', array(
                        'reservation' => $reservation,
                    )));

                // Attache le règlement et le plan d'accès
                $message->attach(\Swift_Attachment::fromPath($this->webRoot . '/documentation/Reglement_brocante_heusy_2014.pdf' ));
				
                $this->get('mailer')->send($message);
		    }

		} catch (\Exception $e) {
			// Si exception durant transaction
	        $this->addFlash('sonata_flash_error', "Erreur lors de l'envoi du mail de réservation. Veuillez réessayer");

	        return new RedirectResponse(
	          $this->admin->generateUrl('list',$this->admin->getFilterParameters())
	        );
    	}

    	if ( $nbParticipants > 1 )
    		$message = "<strong>{$nbParticipants}</strong> emails de réservation envoyés !";
    	else
    		$message = "<strong>1</strong> email de réservation a bien été envoyé.";

		// Si tout s'est bien passé
	    $this->addFlash('sonata_flash_success', $message);

	    return new RedirectResponse(
	      $this->admin->generateUrl('list',$this->admin->getFilterParameters())
	    );
	}
}
