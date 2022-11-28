<?php

namespace Ppro\Hw5;

class App extends \Exception
{
    private string $postString;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        if (!isset($_POST['string']))
            throw new \Exception('Parameter not defined');
        $this->postString = $_POST['string'];
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $response = new Response();

        $this->setValidationInfo($response);
        $this->setServerInfo($response);

        return $response->getContent();
    }

    /** Получение информации о валидности строки запроса
     * @param Response $response
     * @return void
     */
    private function setValidationInfo(Response $response)
    {
        $validator = new Validator($this->postString);
        $status = $validator->run();
        $response->setHeader($status);
        $response->setContent($status ? 'Successful check' : 'Unsuccessful check');
    }

    /** Получение информации о текущем сервере и пользователе
     * @param Response $response
     * @return void
     */
    private function setServerInfo(Response $response): void
    {
            $user = User::getInstance();
            $response->setContent("Сервер: " . $_SERVER['HOSTNAME']);
            $response->setContent("Сессия: " . session_id());
            $response->setContent("Посещение: " . $user->getVisit());
    }
}