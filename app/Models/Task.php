<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['task_name', 'description', 'status', 'due_date'])]
class Task extends Model
{
    protected function casts(): array
    {
        return [
            'due_date' => 'date',
        ];
    }
}