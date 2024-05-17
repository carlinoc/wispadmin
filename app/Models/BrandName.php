<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandName extends Model
{
    use HasFactory;
    protected $table = 'brandname';
    public $timestamps = false;
}
