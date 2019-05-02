<?php

namespace App\Services\Loaders;

interface PaginatorInterface
{
    /**
     * @param array $config
     * @return array
     */
    function paginate(array $config): array;
}