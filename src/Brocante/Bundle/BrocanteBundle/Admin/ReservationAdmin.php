<?php
namespace Brocante\Bundle\BrocanteBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ReservationAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $optionsNbEmplacements = array();
        for ($i=1; $i < 20; $i++)
            $optionsNbEmplacements[$i] = $i;

        $formMapper
            ->add('paye', null, array('required' => false, 'label' => 'A payé ?'))
            ->add('nbEmplacements', 'choice', array('choices' => $optionsNbEmplacements, 'required' => true, 'label' => "Nombre d'emplacements"))
            ->add('emplacements', null, array('label' => 'Emplacements voulus (facultatif)', 'required' => false, 'help' => "(facultatif) A renseigner si le brocanteur veut un (ou plusieurs) emplacement(s) particulier(s)"))
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
}