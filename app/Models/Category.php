<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name','display_in_menu','status','deleted_at'];

    public function products()
    {
        $pcount = $this->hasMany(Product::class);
        return $pcount;
    }
}
