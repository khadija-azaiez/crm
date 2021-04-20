<?php


namespace App\Service;


use App\Entity\Product;

class ProductService
{
    public function getProducts()
    {
        $product1 = new Product();
        $product1->setLabel('savon');
        $product1->setId(1);
        $product1->setPrix(25);

        $product2 = new Product();
        $product2->setId(2);
        $product2->setLabel("chocolta");
        $product2->setPrix(15);

        $product3 = new Product();
        $product3->setId(3);
        $product3->setLabel("eau");
        $product3->setPrix(20);

        $product4 = new Product();
        $product4->setId(4);
        $product4->setLabel("papier");
        $product4->setPrix(18);

        return [$product1, $product2, $product3, $product4];
    }


}