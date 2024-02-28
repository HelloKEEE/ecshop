<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";

    public $timestamps = true;

    protected $fillable = [
        'name',
        'introduction'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


}
