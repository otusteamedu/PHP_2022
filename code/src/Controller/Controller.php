<?php

declare(strict_types=1);

namespace Svatel\Code\Controller;

use Svatel\Code\Http\Request\Request;
use Svatel\Code\Http\Response\Response;
use Svatel\Code\Model\User;
use Svatel\Code\Model\UserMapper;

final class Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function add(): Response
    {
        try {
            $user = new User(
                (int)$this->request->getData()['id'],
                $this->request->getData()['name'],
                $this->request->getData()['email'],
                $this->request->getData()['number'],
            );

            $mapper = new UserMapper();
            $mapper->create($user);

            return new Response(201, 'Пользователь успешно добавлен');
        } catch (\Exception $e) {
            return new Response(500, 'Ошибка при добавлении');
        }
    }

    public function findById(): Response
    {
        $mapper = new UserMapper();
        $res = $mapper->findById($this->request->getData()[0]);

        if ($res) {
            return new Response(201, '', $res->toArray());
        } else {
            return new Response(201, 'Пользователь не найден');
        }
    }

    public function update(): Response
    {
        $user = new User();
        $user->setId($this->request->getData()['id']);
        $user->setName($this->request->getData()['name']);
        $user->setNumber($this->request->getData()['number']);
        $user->setEmail($this->request->getData()['email']);

        $mapper = new UserMapper();
        $res = $mapper->update($user);

        if ($res) {
            return new Response(201, 'Данные изменены успешно');
        } else {
            return new Response(201, 'Пользователь не найден');
        }
    }

    public function delete(): Response
    {
        $user = new User();
        $user->setId($this->request->getData()[0]);

        $mapper = new UserMapper();
        $res = $mapper->delete($user);

        if ($res) {
            return new Response(201, 'Пользователь удален успешно');
        } else {
            return new Response(201, 'Пользователь не найден');
        }
    }
}
