<?php

namespace App\Services\Loaders;

use App\Scopes\ScopeInterface;
use Illuminate\Support\Facades\DB;

trait PaginatorTrait
{
    /**
     * @return ScopeInterface
     */
    abstract function getPagination(): ScopeInterface;

    /**
     * @param array $config
     * @return array
     */
    final public function paginate(array $config): array
    {
        $query = $this->query($config);
        $pagination = $this->getPagination();
        if ($pagination::supports($config)) {
            $totalRows = $query->count(DB::raw(1));
            $pagination->apply($query, $config);
        }

        $rows = $query->get();
        $totalRows = $totalRows ?? $rows->count();
        return compact('rows', 'totalRows');
    }
}