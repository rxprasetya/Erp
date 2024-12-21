<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    use HasFactory;

    protected $table = 'vendors';

    protected $fillable = ['id', 'name', 'email', 'mobile', 'address'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;
}
