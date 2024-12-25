<?php

namespace App\Http\Controllers;

use App\Models\Rfqs;
use App\Models\Products;
use App\Models\RfqSales;
use App\Models\Materials;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        # code...
        $products = Products::count();
        $materials = Materials::count();
        $purchases = Rfqs::where('rfqStatus', 'Done')->count();
        $sales = RfqSales::where('rfqSaleStatus', 'Done')->count();

        return view('welcome', compact('products', 'materials', 'purchases', 'sales'));
    }
}
