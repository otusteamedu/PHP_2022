<?php

declare(strict_types=1);

namespace Masteritua\Src\Balancer;

class BalancerDefault
{
    public BalancerHelper $helper;

    public Request $request;

    public Response $response;

    public function __construct()
    {
        $this->helper = new BalancerHelper();
        $this->request = new Request();
        $this->response = new Response();
    }

    public function run(): void
    {

        try {

            if (!$this->request->checkPost()) {
                throw new \RuntimeException('Error: empty string');
            }

            $string = $this->request->getParam('string');

            if (!$this->helper->checkStringBrackets($string)) {
                throw new \RuntimeException('Error: string in not valid');
            }

            echo 'All is ok!';

        } catch (\Exception $e) {
            $this->response->getHeaderCode();
            echo $e->getMessage(); exit;
        }
    }
}
