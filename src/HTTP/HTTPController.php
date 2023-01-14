<?php

namespace App\HTTP;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Traits\HttpResponseTrait;

class HTTPController
{
    use HttpResponseTrait;

    public function checkBracesNum(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $data = file_get_contents('php://input');

            if (!$data) {
                return $this->errorResponse(
                    $response,
                    'Ай ай пустое значение не допускается',
                    400,
                );
            }

            if (is_string($data)) {
                $count = 0;
                for ($i = 0; $i < strlen($data); $i++) {
                    if ($data[$i] === '(') {
                        $count++;
                    }

                    if ($data[$i] === ')') {
                        $count--;
                    }
                }

                if ($count < 0) {
                    return $this->errorResponse(
                        $response,
                        'Получилось не очень. Пересчитай',
                        400,
                    );
                }

                if ($count !== 0) {
                    return $this->errorResponse(
                        $response,
                        'Получилось не очень. Пересчитай',
                        400,
                    );
                }

                return $this->successResponse($response);
            }
        } catch (\Exception $e) {
            return $this->errorResponse(
                $response,
                $e->getMessage(),
                400,
            );
        }
    }
}
