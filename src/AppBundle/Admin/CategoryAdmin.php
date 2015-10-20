<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Pix\SortableBehaviorBundle\Services\PositionHandler;

class CategoryAdmin extends Admin
{
    protected $context = 'default';
    public $last_position = 0;

    private $positionService;

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'position',
    );

    public function setPositionService(PositionHandler $positionHandler)
    {
        $this->positionService = $positionHandler;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        // ...
        $collection->add('move', $this->getRouterIdParameter().'/move/{position}');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('title')
            ->add('enabled')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->last_position = $this->positionService->getLastPosition($this->getRoot()->getClass());
        $listMapper
            ->add('id')
            ->add('title')
            ->add('categoryParent', 'sonata_type_model_list', array('required' => false))
            ->add('enabled')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                    'move' => array(
                        'template' => 'PixSortableBehaviorBundle:Default:_sort.html.twig'
                    ),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('enabled')
            ->add('title')
            ->add('prevDescription')
            ->add('description', 'ckeditor')
            ->add('categoryParent', 'sonata_type_model_list', array('required' => false))
            ->add('media', 'sonata_type_model_list', array(
                'required' => false,
                'label' => 'Изображение'
            ), array(
                'link_parameters' => array(
                    'context' => $this->context,
                )
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('prevDescription')
            ->add('description')
            ->add('enabled')
        ;
    }
}
