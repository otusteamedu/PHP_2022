<?php

declare(strict_types=1);

namespace Eliasjump\Elasticsearch;

class InputClient
{
   private const PARAMS = ['name:', 'category::', 'max_cost::', 'in_stock'];

   public function __construct()
   {
       $params = getopt('', self::PARAMS);
       var_dump($params);
   }
}