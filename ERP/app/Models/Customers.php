<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = ['id', 'customerName', 'customerEmail', 'customerMobile', 'customerAddress'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;
}
