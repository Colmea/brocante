<?php
namespace Brocante\Bundle\BrocanteBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class EmplacementAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('zone')
            ->add('numero')
            ->add('surface')
            ->add('remarque')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('zone')
            ->add('numero')
            ->add('surface')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('zone')
            ->addIdentifier('numero')
            ->add('remarque')
            ->add('surface')  
            ->add('isFree', 'boolean', array('label' => 'Libre ?'))

        ;
    }
}