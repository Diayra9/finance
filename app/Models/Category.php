<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'tb_category';
    
    protected $primaryKey = 'id';

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
