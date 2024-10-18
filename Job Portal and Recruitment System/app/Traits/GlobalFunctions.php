<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;
trait GlobalFunctions
{
    public static function selectAllExcept($model ,$excludedColumns = []): array
    {
        $columns = Schema::getColumnListing($model->getTable());

        return array_diff($columns, $excludedColumns);
    }
}
