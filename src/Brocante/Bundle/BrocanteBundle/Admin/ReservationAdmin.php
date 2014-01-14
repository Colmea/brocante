<?php
namespace Brocante\Bundle\BrocanteBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Brocante\Bundle\BrocanteBundle\Entity\Emplacement;

class ReservationAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {


        $em = $this->modelManager->getEntityManager('Brocante\Bundle\BrocanteBundle\Entity\Emplacement');

        $query = $em->createQueryBuilder('e')
                    ->select('e')
                    ->from('Brocante\Bundle\BrocanteBundle\Entity\Emplacement', 'e')
                    ->where('e.reservation IS NULL')
                    ->orderBy('e.zone, e.numero', 'ASC');

        $optionsNbEmplacements = array();
        for ($i=1; $i < 20; $i++)
            $optionsNbEmplacements[$i] = $i;

        $formMapper
            ->add('paye', null, array('required' => false, 'label' => 'A payé ?'))
            ->add('nbEmplacements', 'choice', array('choices' => $optionsNbEmplacements, 'required' => true, 'label' => "Nombre d'emplacements"))
            ->with('Emplacements')
                ->add('emplacements', null, array(
                    /*'query_builder' => $query,*/
                    'label' => 'Emplacements',
                    'required' => false,
                    'help' => "(facultatif) A renseigner si le brocanteur veut un (ou plusieurs) emplacement(s) particulier(s)"
                    )
                )
                ->add('isWanted', null, array(
                    'required' => false,
                    'label' => 'Emplacements voulus?',
                    'help' => "Est-ce que la personne voulait ces emplacements ?"))
            ->end()
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('participant')
            ->add('paye')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('participant')
            ->add('paye')
        ;
    }

    public function prePersist($reservation)
    {
        $emplacements = $reservation->getEmplacements();
        foreach ( $emplacements as $emplacement ) {
            $emplacement->setReservation($reservation);
            $reservation->addEmplacement($emplacement);
        }
    }

    public function preUpdate($reservation)
    {
        $emplacements = $reservation->getEmplacements();
        foreach ( $emplacements as $emplacement ) {
            $emplacement->setReservation($reservation);
            $reservation->addEmplacement($emplacement);
        }
    }
}