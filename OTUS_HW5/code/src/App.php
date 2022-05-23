<?php
declare(strict_types=1);

namespace PShilyaev;


class App
{
    protected Response $response;
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->response = new Response();
        $this->request = $request;
    }

    public function Run(Request $request) : Response {
        try {
            $string = $request->getString();
        }
        catch (\Exception $e) {
            $this->response->setStatus("400");
            $this->response->setMessage($e->getMessage());
            return $this->response;
        }

        if (StringService::CheckString($string)===true)
        {
            $this->response->setStatus("200");
            $this->response->setMessage("OK");
        }
		else if (StringService::CheckString($string)===NULL)
        {
            $this->response->setStatus("400");
            $this->response->setMessage("Bad Request");
        }
        else
        {
            $this->response->setStatus("400");
            $this->response->setMessage("NOT VALID STRING");
        }

        return $this->response;
    }

}