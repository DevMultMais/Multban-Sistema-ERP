<?php

namespace App\Models\Multban\Traits;

use Illuminate\Database\Eloquent\Model;

trait DbSysClientTrait
{
    public function getConnectionName(): string
    {
        return 'dbsysclient';
    }
}
