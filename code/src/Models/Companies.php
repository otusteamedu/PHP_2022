<?php

namespace Otus\App\Models;

use Otus\App\Viewer\View;

class Companies extends ActiveRecordEntity
{
    protected static $table = 'companies';

    static $companies;

    public static function getCompanies($user_id): array
    {
        try {
            $companies = Companies::get('user_id', "$user_id");
            static::$companies= $companies;
        } catch (\Exception $e) {
            View::render('error', [
                'title' => '503 - Service Unavailable',
                'error_code' => '503 - Service Unavailable',
                'result' => 'Cервер временно не имеет возможности обрабатывать запросы по техническим причинам'
            ]);
        }
        return static::$companies;
    }
}
