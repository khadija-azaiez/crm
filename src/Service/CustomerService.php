<?php


namespace App\Service;


use App\Entity\Customer;

class CustomerService
{

    public function getcustomer()
    {
        $customer1 = new Customer();
        $customer1->setId(1);
        $customer1->setName("ahmed");
        $customer1->setPhone("7469311");
        $customer1->setCin(2215963);
        $customer2 = new Customer();
        $customer2->setId(2);
        $customer2->setName("khadija");
        $customer2->setPhone("569348");
        $customer2->setCin(25189036);
        $customer3 = new Customer();
        $customer3->setId(3);
        $customer3->setName("moussa");
        $customer3->setPhone("255496523");
        $customer3->setCin(235941);

        $customers = [$customer1, $customer2, $customer3];

        return $customers;
    }

}