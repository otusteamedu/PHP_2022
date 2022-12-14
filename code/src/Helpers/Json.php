<?php

namespace Ppro\Hw12\Helpers;

class Json
{
    private string $filepath;
    private string $content;

    public function __construct(string $filePath)
    {
        $this->filepath = $filePath;
        if(empty($this->filepath) || !file_exists($this->filepath))
            throw new \Exception("Not correct filepath or file not exist\r\n");
        $this->setContent();
    }

    public function setContent()
    {
        if(!is_string($content = file_get_contents($this->filepath)))
            throw new \Exception("JSON file read error\r\n");
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getJsonValue(bool $asArray = false)
    {
        return json_decode($this->content, $asArray, 512, JSON_THROW_ON_ERROR);
    }
}