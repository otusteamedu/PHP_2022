<?php

namespace Core\Components;

use Core\Helpers\Inflector;

class Request
{
    /**
     * @var string $url;
     */
    protected string $uri;

    public function __construct()
    {
        $this->uri = $this->getUri();
    }

    /**
     * @return boolean
     */
    public function hasQueryString() :bool
    {
        return (boolean)!empty(ltrim($this->uri, "/"));
    }

    /**
     * @param null|string $uri
     * @return string
     */
    public function getControllerNamespace($uri = null) :string
    {
        if($uri){
            $arr = $this->queryStringToArray($uri);
        }else{
            $arr = $this->queryStringToArray($this->uri);
        }

        $arrCount = count($arr);

        if($arrCount <= 2) {
            return !empty($arr[0]) ? "\\".Inflector::id2camel($arr[0]) : '';
        } else {
            $namespace = '';
            for($i = 0; $i < ($arrCount -1); ++$i){
                if($i === ($arrCount -2)){
                    $namespace .= "\\".Inflector::id2camel($arr[$i]);
                }else{
                    $namespace .= "\\".$arr[$i];
                }
            }
            return $namespace;
        }
    }

    /**
     * @param null|string $uri
     * @return string|null
     */
    public function getControllerAction(string $uri = null)
    {
        if($uri){
            $arr = $this->queryStringToArray($uri);
        }else{
            $arr = $this->queryStringToArray($this->uri);
        }

        $arrCount = count($arr);
        if($arrCount >= 2) {
            return !empty($arr[$arrCount-1]) ? $arr[$arrCount-1] : null;
        }
        return null;
    }

    /**
     * @param string $str
     * @return array
     */
    protected function queryStringToArray(string $str) :array
    {
        return explode('/', ltrim($str, "/"));
    }

    /**
     * @return string
     */
    protected function getUri() :string
    {
        $chunk_uri = explode('?', $_SERVER['REQUEST_URI']);

        return is_array($chunk_uri) && count($chunk_uri) ? array_shift($chunk_uri) : '';
    }
}