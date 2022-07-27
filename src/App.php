<?php

use Assembler\InputParametersDtoAssembler;
use Command\FindBookCommand;
use DI\Container;
use Dto\InputParametersDto;
use Elastic\Elasticsearch\ClientBuilder;
use Logger\Logger;
use ValueObject\Config;
use ValueObject\Parameter;
use Exception\InvalidArgumentException;

class App
{
    private const OPTIONAL_PARAMETER = '::';

    private FindBookCommand $findBookCommand;
    private Logger $logger;
    private InputParametersDtoAssembler $inputParametersDtoAssembler;

    public function __construct()
    {
        $container = new Container();
        $this->findBookCommand = $container->get(FindBookCommand::class);
        $this->logger = $container->get(Logger::class);
        $this->inputParametersDtoAssembler = $container->get(InputParametersDtoAssembler::class);
    }

    public function run(): void
    {
        try {
            $this->logger->info('Work have started.');

            $config = (new Config())->getConfig();
            $client = ClientBuilder::create()
                ->setHosts([
                    $config->host
                ])
                ->build();

            $parameters = $this->initParameters();
            $this->findBookCommand->execute($parameters, $client, $config);
        } catch (Throwable $exception) {
            $this->logger->critical($exception);
        } finally {
            $this->logger->info('Work have ended.');
        }
    }

    /**
     * @return InputParametersDto
     * @throws InvalidArgumentException
     */
    private function initParameters(): InputParametersDto
    {
        $parameters = getopt(
            't::s::c::pf::pt::s::l::o::',
            [
                Parameter::TITLE . self::OPTIONAL_PARAMETER,
                Parameter::SKU . self::OPTIONAL_PARAMETER,
                Parameter::CATEGORY . self::OPTIONAL_PARAMETER,
                Parameter::PRICE_LOW . self::OPTIONAL_PARAMETER,
                Parameter::PRICE_HIGH . self::OPTIONAL_PARAMETER,
                Parameter::LIMIT . self::OPTIONAL_PARAMETER,
                Parameter::OFFSET . self::OPTIONAL_PARAMETER
            ]
        );

        if (!$parameters) {
            throw new InvalidArgumentException('Wrong script options.');
        }

        return $this->inputParametersDtoAssembler->assemble($parameters);
    }
}
