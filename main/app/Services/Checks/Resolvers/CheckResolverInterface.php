<?php

namespace App\Services\Checks\Resolvers;

interface CheckResolverInterface
{
    /**
     * @return string
     */
    public function getMessage(): string;
}