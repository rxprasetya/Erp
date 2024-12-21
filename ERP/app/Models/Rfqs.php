<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rfqs extends Model
{
    use HasFactory;

    protected $table = 'rfqs';

    protected $fillable = ['id', 'rfqCode', 'vendorID', 'orderDate', 'materialID', 'qtyOrder', 'priceOrder', 'totalOrder',  'rfqStatus'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public function vendor(){
        // lokasi, foreign(relation table), primary key(main table)
        return $this->belongsTo('App\Models\Vendors', 'vendorID', 'id');
    }
    
}
