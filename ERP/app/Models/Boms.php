<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boms extends Model
{
    use HasFactory;

    protected $table = 'boms';

    protected $fillable = ['id', 'bomCode', 'productID', 'qtyProduct', 'materialID', 'qtyMaterial', 'cost', 'unitPrice'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public function product(){
        // lokasi, foreign(relation table), primary key(main table)
        return $this->belongsTo('App\Models\Products', 'productID', 'id');
    }

    public function material(){
        // lokasi, foreign(relation table), primary key(main table)
        return $this->belongsTo('App\Models\Materials', 'materialID', 'id');
    }

}
