<?php

namespace App\Models\Mykj;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LBangsa extends Model
{
    use HasFactory;
    protected $table = "l_bangsa";
    protected $connection = 'pgsqlmykj';
}
