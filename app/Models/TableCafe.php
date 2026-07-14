<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableCafe extends Model
{
    use HasFactory;

    protected $table = 'table_cafes';

    protected $fillable = [
        'number',
        'status',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'table_id');
    }
}
