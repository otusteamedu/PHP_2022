<?php

namespace Nka\Otus\Core\Http;

use Nka\Otus\Core\Http\Headers\ContentTypeHeader;
use Nka\Otus\Core\Http\Headers\HeaderInterface;
use Nka\Otus\Core\View;

class Response
{
    /**
     * @var array<HeaderInterface>
     */
    public array $headers = [];

    public string|View $body;
    public int $status = 200;

    public function createResponse(
        string|View $body,
        int $status = 200
    ): static
    {
        $this->body = $body;
        $this->status = $status;
        return $this;
    }


    protected function prepareResponse(): string
    {
        $header = new ContentTypeHeader();
        if ($this->body instanceof View) {
            $header->setValue(ContentTypeHeader::HTML);
            $rawBody = $this->body->renderBody();
        } else {
            $header->setValue(ContentTypeHeader::JSON);

            $bodyArray['status'] = $this->status >= 400 ? 'error' : 'success';
            $bodyArray['code'] = $this->status;
            $bodyArray['message'] = $this->body;

            $rawBody = json_encode($bodyArray, JSON_UNESCAPED_UNICODE);
        }
        $this->addHeader($header);
        return $rawBody;
    }

    public function send()
    {
        $rawBody = $this->prepareResponse();
        $this->sendHeaders();
        echo $rawBody;
    }

    public function sendHeaders()
    {
        http_response_code($this->status);
        array_walk($this->headers, fn (HeaderInterface $header) => header((string)$header));
    }

    public function addHeader(HeaderInterface $header)
    {
        $this->headers[] = $header;
    }

}
