<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productions extends Model
{
    use HasFactory;

    protected $table = 'productions';

    protected $fillable = ['id', 'productionCode', 'qtyProduction', 'productionDate', 'bomID', 'productionStatus'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public function bom(){
        // lokasi, foreign(relation table), primary key(main table)
        return $this->belongsTo('App\Models\Boms', 'bomID', 'id');
    }
}
