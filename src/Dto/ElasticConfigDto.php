<?php

namespace Dto;

class ElasticConfigDto
{
    public function __construct(
        public string $host,
        public string $index
    ) { }
}
