<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'picture',
        'price',
        'category_id'
    ];
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
