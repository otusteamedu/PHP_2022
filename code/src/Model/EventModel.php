<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw11\Model;

use Nikcrazy37\Hw11\Exception\EmptyParamException;
use Nikcrazy37\Hw11\Exception\EmptyRequestException;

class EventModel
{
    /**
     * @var array
     */
    private array $input;

    /**
     * @param string $mode
     * @return array
     * @throws EmptyRequestException
     */
    public function getRequest(string $mode): array
    {
        $this->input = filter_input_array(INPUT_POST);

        if (empty($this->input)) {
            throw new EmptyRequestException();
        }

        $mode = ucfirst($mode);
        $method = "get$mode";

        return $this->$method();
    }

    /**
     * @return array
     * @throws EmptyParamException
     */
    private function getCreate(): array
    {
        if (empty($this->input["score"])) {
            throw new EmptyParamException("score");
        }
        if (empty($this->input["param"])) {
            throw new EmptyParamException("param");
        }

        $request["score"] = $this->input["score"];

        $request["param"] = $this->prepareParam();

        return $request;
    }

    /**
     * @return array
     * @throws EmptyParamException
     */
    private function getUpdate(): array
    {
        $request = $this->getCreate();

        if (empty($this->input["id"])) {
            throw new EmptyParamException("id");
        }

        $request["id"] = $this->input["id"];

        return $request;
    }

    /**
     * @return array
     * @throws EmptyParamException
     */
    private function getRead(): array
    {
        if (empty($this->input["id"])) {
            throw new EmptyParamException("id");
        }

        $request["id"] = $this->input["id"];

        return $request;
    }

    /**
     * @return array
     * @throws EmptyRequestException
     */
    private function getDelete(): array
    {
        if (isset($this->input["id"])) {
            $request["id"] = $this->input["id"];
        }
        if (isset($this->input["clear"])) {
            $request["clear"] = $this->input["clear"];
        }
        if (empty($request)) {
            throw new EmptyRequestException();
        }

        return $request;
    }

    /**
     * @return array
     * @throws EmptyParamException
     */
    private function getSearch(): array
    {
        if (empty($this->input["param"])) {
            throw new EmptyParamException("param");
        }

        $request["param"] = $this->prepareParam();

        return $request;
    }

    /**
     * @return mixed
     */
    private function prepareParam(): mixed
    {
        $param = $this->input["param"];
        $arParam = explode("\n", $param);

        array_walk($arParam, function ($param) use (&$request){
            $tmp = explode("=", $param);
            $request[$tmp[0]] = $tmp[1];
        });

        return $request;
    }
}