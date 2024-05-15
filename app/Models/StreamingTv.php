<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreamingTv extends Model
{
    use HasFactory;
    protected $table = 'streamingtv';
    public $timestamps = false;
}
