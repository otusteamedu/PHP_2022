<?php

namespace App\Application;

use App\Application\Contracts\ProductStorageInterface;

class App
{
    protected $productStorage;

    /**
     * @param $productStorage
     */
    public function __construct(ProductStorageInterface $productStorage)
    {
        $this->productStorage = $productStorage;
    }

    public function run()
    {
        //Создаем Data Mapper
        $productMapper = new ProductMapper($this->productStorage);

        //Получаем однин продукт
        $user = $productMapper->getById(1);
        echo $user->getName().PHP_EOL;


        //Получаем все продукты с наименованием 'HDD'
        $users = $productMapper->getByName('HDD');
        foreach ($users as $user) {
            echo $user->getName().PHP_EOL;
        }

    }


}