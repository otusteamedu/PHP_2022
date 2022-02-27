<?php
declare(strict_types=1);

namespace Decole\NginxBalanceApp;

use Decole\NginxBalanceApp\Core\Render;
use Decole\NginxBalanceApp\Core\Request;
use Decole\NginxBalanceApp\Core\Response;
use Decole\NginxBalanceApp\Core\Validator;

class App
{
    private Render $render;
    private Request $requester;
    private Response $responder;
    private Validator $validator;

    public function __construct()
    {
        $this->render = new Render();
        $this->requester = new Request();
        $this->responder = new Response();
        $this->validator = new Validator();
    }

    public function run(): ?string
    {
        $params = [];

        if ($this->requester->request('field')) {
            $field = $this->requester->request('field');
            $validate = $this->validator->validateParentheses($field);

            $params = [
                'field' => $field,
                'validation' => $validate,
            ];
        }

        $data = $this->render->compile('index.php', $params);

        return $this->responder
            ->setData($data)
            ->setCode(Response::SERVER_SUCCESS_REQUEST)
            ->getData();
    }
}