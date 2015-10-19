<?php

namespace AppBundle\Admin;

use Pix\SortableBehaviorBundle\Services\PositionHandler;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ProductAdmin extends Admin
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
            ->add('description')
            ->add('isDelete')
            ->add('cost')
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
            ->add('prevDescription')
            ->add('description')
            ->add('isDelete')
            ->add('cost')
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
            ->add('title')
            ->add('prevDescription')
            ->add('description')
            ->add('cost')
            ->add('productMedia', 'sonata_type_collection', array(
                'cascade_validation' => true,
                'type_options' => array('delete' => false),
            ), array(
                'edit' => 'inline',
                'required' => false,
                'inline' => 'table',
                'sortable' => 'position',
                'targetEntity' => 'AppBundle\Entity\ProductHasMedia',
                'link_parameters' => array(
                    'context' => $this->context,
                ),
                'admin_code' => 'app.admin.product_has_media'
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
            ->add('cost')
        ;
    }

    public function prePersist($product)
    {
        $product->setProductMedia($product->getProductMedia());
    }
    public function preUpdate($product)
    {
        $product->setProductMedia($product->getProductMedia());
    }
}
