<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfqSales extends Model
{
    use HasFactory;

    protected $table = 'rfq_sales';

    protected $fillable = ['id', 'rfqSaleCode', 'customerID', 'saleDate', 'productID', 'qtySold', 'priceSale', 'totalSold',  'rfqSaleStatus'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public function customer(){
        // lokasi, foreign(relation table), primary key(main table)
        return $this->belongsTo('App\Models\Customers', 'customerID', 'id');
    }
}
