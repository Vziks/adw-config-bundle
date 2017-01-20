<?php

namespace ADW\ConfigBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use ADW\ConfigBundle\Form\Type\AllowIpType;

/**
 * Class ConfigSiteAdmin.
 * Project proplan.
 * @author Anton Prokhorov
 */

class ConfigSiteAdmin extends AbstractAdmin
{

    /**
     * @inheritdoc
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'edit']);
        parent::configureRoutes($collection);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('turn_off')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('turn_off')
            ->add('startAt')
            ->add('stopAt')
            ->add('allowips','collection', array(
                'type' => new AllowIpType(),
                'allow_add'   => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'options' => array('data_class' => 'ADW\ConfigBundle\Entity\AllowIp'),
                )
            )

        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
        ;
    }

}