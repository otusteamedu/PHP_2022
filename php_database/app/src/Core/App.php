<?php

namespace App\Db\Core;

use App\Db\Database\DataMapper\Entity\Company;
use App\Db\Database\DataMapper\Mapper\CompanyMapper;
use DI\Container;
use DI\ContainerBuilder;
use Symfony\Component\Dotenv\Dotenv;
use WS\Utils\Collections\CollectionFactory;

class App
{
    private Container $container;

    public function __construct()
    {
        $builder = new ContainerBuilder();
        $this->container = $builder->build();
    }

    public function run(): void
    {
        $this->configure();

        try {
            $this->dataMapperExample();
        } catch (\Exception $e) {
            header('Status: 500 Error: ' . $e->getMessage());
        }
    }

    private function dataMapperExample()
    {
        $company = Company::create()
            ->setName('Яндекс')
            ->setAddress('Москва')
            ->setPhone('+79284665868')
            ->setEmail('test@gmail.com');

        /** @var CompanyMapper $companyMapper */
        $companyMapper = $this->container->get(CompanyMapper::class);
        $companyMapper->insert($company);
        $companies = $companyMapper->findAll();

        $arrayCompanies = CollectionFactory::from($companies)
            ->stream()
            ->map(function (Company $company) {
                return $company->toArray();
            })->toArray();

        echo json_encode($arrayCompanies, JSON_PRETTY_PRINT);
    }

    private function configure(): void
    {
        $dotenv = new Dotenv();
        $dotenv->load($_SERVER['DOCUMENT_ROOT'].'/.env');
    }
}