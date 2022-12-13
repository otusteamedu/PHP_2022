<?php

declare(strict_types=1);

namespace Eliasjump\Elasticsearch;

class InputHandler
{
   private const PARAMS = ['name:', 'category::', 'max_cost::', 'in_stock'];

   public static function getParams(): array
   {
       return getopt('', self::PARAMS);
   }
}