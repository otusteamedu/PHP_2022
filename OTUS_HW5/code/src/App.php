<?php
declare(strict_types=1);

namespace Shilyaev\Strings;


class App
{
    protected Response $response;
    protected Request $request;
    protected string $string;

    public function __construct()
    {
        $this->response = new Response();
        $this->request = new Request();
    }

    public function run() : string {

        try {
            $this->string = $this->request->getString();
        }
        catch (\Exception $e) {
            $this->response->setStatus(400);
            $this->response->setMessage($e->getMessage());
            return $this->response->getMessage();
        }
        try {
            if (StringService::CheckString($this->string)) {
                $this->response->setStatus(200);
                $this->response->setMessage("OK");
            } else {
                $this->response->setStatus(400);
                $this->response->setMessage("NOT VALID STRING");
            }
        } catch (\Exception $e) {
            $this->response->setStatus(400);
            $this->response->setMessage($e->getMessage());
        }
        return $this->response->getMessage();
    }

}