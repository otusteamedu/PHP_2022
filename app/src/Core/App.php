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

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $builder = new ContainerBuilder();
        $this->container = $builder->build();

        $dotenv = new Dotenv();
        $dotenv->load('/var/www/html/.env');
    }

    /**
     * @return void
     */
    public function run(): void
    {
        try {
            $this->dataMapperExample();
            $this->identityMapExample();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @return void
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    private function dataMapperExample(): void
    {
        $company = Company::create()
            ->setName('TestCompany')
            ->setAddress('Moscow')
            ->setPhone('+79250028756')
            ->setEmail('test@mail.com');

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

    /**
     * @return void
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    private function identityMapExample(): void
    {
        $user = User::create()
            ->setName('TestName')
            ->setSurname('TestSurname');

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

    /**
     * @param string $header
     * @param array $content
     * @return void
     */
    private function print(string $header, array $content): void
    {
        echo "\n" . $header . "\n";
        echo json_encode($content, JSON_PRETTY_PRINT);
        echo "\n\n";
    }
}