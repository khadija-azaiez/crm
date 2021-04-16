<?php


namespace App\Service;


use App\Entity\Supplier;


class SupplierService
{

    public function getSupplier()
    {
        $supplier1= new Supplier();
        $supplier1->setId(1);
        $supplier1->setName("ahmed");
        $supplier1->setPhone(25465);
        $supplier1->setCodeTva(596);

        $supplier2= new Supplier();
        $supplier2->setId(2);
        $supplier2->setName("asma");
        $supplier2->setPhone(2546);
        $supplier2->setCodeTva(599);

        $supplier3= new Supplier();
        $supplier3->setId(3);
        $supplier3->setName("amin");
        $supplier3->setPhone(2846);
        $supplier3->setCodeTva(519);

       return [$supplier1, $supplier2, $supplier3];

    }
}