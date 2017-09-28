<?php
/**
 * Magento 2 Training Project
 * Module Training/Helloworld
 */
namespace Training\Helloworld\Controller\Product;

/**
 * Action: Product/Categories
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Categories extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * PHP Constructor
     *
     * @param \Magento\Framework\App\Action\Context                           $context                   Action context
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory  $productCollectionFactory  Factory
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory Factory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
    ) {
        parent::__construct($context);

        $this->productCollectionFactory = $productCollectionFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * Execute the action
     *
     * @return void
     */
    public function execute()
    {
        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection */
        //instancie bdd
        $productCollection = $this->productCollectionFactory->create();

        // BDD request who get product_id of product who have 'bag' in their name
        $productCollection
            ->addAttributeToFilter('name', array('like' => '%bag%'))
            ->addCategoryIds()
            ->load();

        // load => lance l'exec de la requette
        $categoryIds = [];
        foreach ($productCollection->getItems() as $product) {
            /** @var \Magento\Catalog\Model\Product $product */

            // crea d'un array qui contient tout les id des categories
            $categoryIds = array_merge($categoryIds, $product->getCategoryIds());
        }

        // suppression des doublons
        $categoryIds = array_unique($categoryIds);

        /** @var \Magento\Catalog\Model\ResourceModel\Category\Collection $catCollection */
        $catCollection = $this->categoryCollectionFactory->create();

        // get name of entity_id in $categoryIds
        $catCollection
            ->addAttributeToFilter('entity_id', array('in' => $categoryIds))
            ->addAttributeToSelect('name')
            ->load();

        // start construct of tab
        $html = '<ul>';

        //$productCollection => product id of product with "bag" in their name
         foreach ($productCollection->getItems() as $product) {
            // construct of page
            $html.= '<li>';
            // create table of id + sku + name
            $html.= $product->getId().' => '.$product->getSku().' => '.$product->getName();
            $html.= '<ul>';
            foreach ($product->getCategoryIds() as $categoryId) {
                /** @var \Magento\Catalog\Model\Category $category */
                $category = $catCollection->getItemById($categoryId);
                $html.= '<li>'.$categoryId.' => '.$category->getName().'</li>';
            }
            $html.= '</ul>';
            $html.= '</li>';
        }
        $html.= '</ul>';
        $this->getResponse()->appendBody($html);
    }
}