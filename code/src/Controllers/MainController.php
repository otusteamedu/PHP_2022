<?php
declare(strict_types=1);

namespace Decole\NginxBalanceApp\Controllers;

use Decole\NginxBalanceApp\Core\Render;
use Decole\NginxBalanceApp\Core\Request;
use Decole\NginxBalanceApp\Core\Response;
use Decole\NginxBalanceApp\Core\Validator;

class MainController
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

    public function index(): ?string
    {
        $params = [];

        if ($this->requester->isPost()) {
            $field = $this->requester->request('field');
            $validate = $this->validator->validateParentheses($field);

            $params = [
                'field' => $field,
                'validation' => $validate,
            ];
        }

        $data = $this->render->compile('index.php', $params);

        $response = $this->responder
            ->setData($data);

        if ($validate['is_validated']) {
            $response->setCode(Response::SERVER_SUCCESS_REQUEST);
        } else {
            $response->setCode(Response::SERVER_BAD_REQUEST);
        }

        return $response->getData();
    }
}