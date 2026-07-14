<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'total',
        'status',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function table()
    {
        return $this->belongsTo(TableCafe::class, 'table_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
