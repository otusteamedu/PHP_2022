<?php

namespace App\Db\Core;

use App\Db\Database\DataMapper\Entity\Company;
use App\Db\Database\DataMapper\Mapper\CompanyMapper;
use App\Db\Database\IdentityMap\Entity\User;
use App\Db\Database\IdentityMap\Mapper\UserMapper;
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

        $dotenv = new Dotenv();
        $dotenv->load($_SERVER['DOCUMENT_ROOT'].'/.env');
    }

    public function run(): void
    {
        try {
            $this->dataMapperExample();
            $this->identityMapExample();
        } catch (\Exception $e) {
            header('Status: 500 Error: ' . $e->getMessage());
        }
    }

    private function dataMapperExample(): void
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

        $this->print('DATA MAPPER', $arrayCompanies);
    }

    private function identityMapExample(): void
    {
        $user = User::create()
            ->setName('Павел')
            ->setSurname('Гапоненко');

        $userMapper = $this->container->get(UserMapper::class);
        $userMapper->insert($user);
        $users = $userMapper->findAll();

        $arrayUsers = CollectionFactory::from($users)
            ->stream()
            ->map(function (User $user) {
                return $user->toArray();
            })
            ->toArray();

        $this->print('IDENTITY MAP', $arrayUsers);
    }

    private function print(string $header, array $content): void
    {
        echo "\n" . $header . "\n";
        echo json_encode($content, JSON_PRETTY_PRINT);
    }
}