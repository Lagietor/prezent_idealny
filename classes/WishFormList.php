<?php 

class WishFormList extends ObjectModel
{
    public $id_wishformlist;
    public $id_product;
    public $product_name;
    public $id_category;
    public $category_name;

    public static $definition = [
        'table' => 'wishformlist',
        'primary' => 'id_product',
        'multilang' => true,
        'fields' => [
            'id_product' => ['type' => self::TYPE_INT],
            'product_name' => ['type' => self::TYPE_STRING],
            'id_category' => ['type' => self::TYPE_INT],
            'category_name' => ['type' => self::TYPE_STRING]
        ]
    ];
}
