<?php

namespace app\services;

use app\models\UserQuery;

class UserQueryService {
//    private UserQuery $model;
//
//    public function __construct(UserQuery $userQuery) {
//        $this->model = $userQuery;
//    }
//
//    public function getModel(): UserQuery {
//        return $this->model;
//    }

    public static function addNewQuery(): int {
        $model = new UserQuery();
        $model->insertToDB();
        $model->publishMessage();
        return $model->getId();
    }


    public static function getQueryStatus(int $queryId): ?string {
        $model = self::getModel($queryId);
        return $model->getStatus();
    }

    public static function processQuery(int $queryId): void {
        $model = self::getModel($queryId);
        // какая-то обработка запроса
        sleep(5);
        $model->setStatus('processed');
        $model->updateInDB();
    }

    private static function getModel(int $queryId): UserQuery {
        $model = UserQuery::findById($queryId);
        if (!$model) {
            throw new \Exception('Not found', 404);
        }
        return $model;
    }
}
