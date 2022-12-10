<?php

namespace Otus\App\Models;

use Otus\App\Models\Companies;
use Otus\App\Viewer\View;

class Users extends ActiveRecordEntity
{
    protected static $table = 'users';

    public static function allUsers(): array
    {
        $massif_users = [];
        $k = 0;
        try {
            foreach (Users::findAll() as $users) {
                $massif_users[$k] = [
                    "user_id" => $users['user_id'],
                    "user_name" => $users['user_name'],
                    "user_surname" => $users['user_surname'],
                    "company_id" => $users['company_id']
                ];
                $k++;
            }
        } catch (\Exception $e) {
            View::render('error', [
                'title' => '503 - Service Unavailable',
                'error_code' => '503 - Service Unavailable',
                'result' => 'Cервер временно не имеет возможности обрабатывать запросы по техническим причинам'
            ]);
        }
        return $massif_users;
    }

    public static function getUserCompanies(): array
    {
        if (!empty($_GET['user_id'])) {
            $user_id = $_GET['user_id'];
            $array_companies = [];
            $k = 0;
            try {
                foreach (Companies::getCompanies($user_id) as $companies) {
                    $array_companies[$k] = [
                        "company_name" => $companies['company_name'],
                    ];
                    $k++;
                }
                return $array_companies;
            } catch (\Exception $e) {
                View::render('error', [
                    'title' => '503 - Service Unavailable',
                    'error_code' => '503 - Service Unavailable',
                    'result' => 'Cервер временно не имеет возможности обрабатывать запросы по техническим причинам'
                ]);
            }
        }
    }
}
