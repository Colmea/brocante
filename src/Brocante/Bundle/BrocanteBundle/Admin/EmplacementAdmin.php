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
            ->add('free', 'doctrine_orm_callback', array(
                'label' => 'Libre ?',
                'callback'   => array($this, 'getFreeFilter'),
                'field_type' => 'checkbox'
                ), 'choice', array(
                    'choices' => array(
                        true => 'Oui',
                        false => 'Non',
                        )
                )
            );
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
            ->add('reservation') 
        ;
    }

    public function getFreeFilter($queryBuilder, $alias, $field, $value)
    {
        if (null === $value['value']) {
            return;
        }

        // If filter only free
        if ($value['value']) {
            $queryBuilder->andWhere(sprintf('%s.reservation is NULL', $alias));
        }
        else {
            $queryBuilder->andWhere(sprintf('%s.reservation is not NULL', $alias));
        }


        return true;
    }
}