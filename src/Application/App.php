<?php

namespace App\Application;

use App\Application\Contracts\ProductStorageInterface;
use App\Application\Contracts\ResponseInterface;

class App
{
    protected $productStorage;
    protected $response;

    /**
     * @param $productStorage
     */
    public function __construct(ProductStorageInterface $productStorage, ResponseInterface $response)
    {
        $this->productStorage = $productStorage;
        $this->response = $response;
    }

    public function run()
    {
        //Создаем Data Mapper
        $productMapper = new ProductMapper($this->productStorage);

        //Получаем однин продукт
        $user = $productMapper->getById(1);
        $this->response->out($user->getName().PHP_EOL) ;


        //Получаем все продукты с наименованием 'HDD'
        $users = $productMapper->getByName('HDD');
        foreach ($users as $user) {
            $this->response->out($user->getName().PHP_EOL);
        }

    }


}