<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\RfqSales;
use App\Models\Customers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RfqSalesController extends Controller
{
    //
    public function index()
    {
        # code...
        $rfqSales = RfqSales::select('rfqSaleCode', 'customerID', 'rfqSaleStatus')
                    ->selectRaw('SUM(totalSold) as total')
                    ->orderBy('rfqSaleCode')
                    ->groupBy('rfqSaleCode', 'customerID', 'rfqSaleStatus')
                    ->get();

        return view('menu.sale.rfq-sales.rfq-sales', compact('rfqSales'));
    }

    public function create()
    {
        # code...
        $customers = Customers::get();
        $products = Products::get();
        $date = now()->setTimezone('Asia/Jakarta')->format('Y-m-d');

        return view('menu.sale.rfq-sales.formrfq-sales', compact('customers', 'products', 'date'));
    }

    public function edit(Request $request)
    {
        # code...
        $rfqSaleCode = $request->rfqSaleCode;
        $rfqSale = RfqSales::where('rfqSaleCode', $rfqSaleCode)->first();


        $rfqSales = RfqSales::where('rfqSaleCode', $rfqSaleCode)->get();
        $customers = Customers::get();
        $products = Products::get();

        return view('menu.sale.rfq-sales.formrfq-sales', compact('rfqSales','rfqSale','customers', 'products'));
    }

    public function preview(Request $request)
    {
        # code...
        $rfqSaleCode = $request->rfqSaleCode;
        $rfqSale = RfqSales::where('rfqSaleCode', $rfqSaleCode)->first();


        $rfqSales = RfqSales::where('rfqSaleCode', $rfqSaleCode)->get();
        $customers = Customers::get();
        $products = Products::get();

        return view('menu.sale.rfq-sales.formrfq-sales', compact('rfqSales','rfqSale','customers', 'products'));
    }

    public function insert(Request $request)
    {
        # code...
        $request->validate([
            'customerID' => 'required|exists:customers,id',
            'saleDate' => 'required',
            'productID.*' => 'required|exists:products,id',
            'qtySold.*' => 'required|numeric|max:9999999999',
            'priceSale.*' => 'required|numeric|max:9999999999',
            'totalSold.*' => 'required|numeric|max:9999999999',
        ]);

        $lastRfqSaleRecord = RfqSales::orderBy('rfqSaleCode', 'desc')->first();
        $count = $lastRfqSaleRecord ? $lastRfqSaleRecord->rfqSaleCode : 'RFQ/SLS/0000';
        
        $lastRfqSale = (int) substr($count, 8);
        $rfqSaleCode = 'RFQ/SLS/' . str_pad($lastRfqSale + 1, 4, '0', STR_PAD_LEFT);

        $rfqSalesData = [];
        foreach ($request->productID as $index => $productID) {
            $rfqSalesData[] = [
                'id' => Str::uuid(),
                'rfqSaleCode' => $rfqSaleCode,
                'customerID' => $request->customerID,
                'saleDate' => $request->saleDate,
                'productID' => $productID,
                'qtySold' => $request->qtySold[$index],
                'priceSale' => $request->priceSale[$index],
                'totalSold' => $request->totalSold[$index],
                'rfqSaleStatus' => 'Request',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        RfqSales::insert($rfqSalesData);

        return redirect()
        ->route('rfq-sales')
        ->with('success', 'Successfully created request for quotation sale');
    }

    public function update(Request $request)
    {
        $request->validate([
            'customerID' => 'required|exists:customers,id',
            'saleDate' => 'required',
            'productID.*' => 'required|exists:products,id',
            'qtySold.*' => 'required|numeric|max:9999999999',
            'priceSale.*' => 'required|numeric|max:9999999999',
            'totalSold.*' => 'required|numeric|max:9999999999',
        ]);

        $rfqSaleCode = $request->rfqSaleCode;

        $rfqSale = RfqSales::where('rfqSaleCode', $rfqSaleCode)->first();
        $created_at = $rfqSale->created_at;

        $rfqSalesData = [];
        foreach ($request->productID as $index => $productID) {
            $rfqSalesData[] = [
                'id' => Str::uuid(),
                'rfqSaleCode' => $rfqSaleCode,
                'customerID' => $request->customerID,
                'saleDate' => $request->saleDate,
                'productID' => $productID,
                'qtySold' => $request->qtySold[$index],
                'priceSale' => $request->priceSale[$index],
                'totalSold' => $request->totalSold[$index],
                'rfqSaleStatus' => 'Request',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        RfqSales::where('rfqSaleCode', $rfqSaleCode)->delete();
        RfqSales::insert($rfqSalesData);

        return redirect()
            ->route('rfq-sales')
            ->with('success', 'Successfully updated request for quotation sale');
    }

    public function delete(Request $request)
    {
        # code...
        $rfqSaleCode = $request->rfqSaleCode;

        $rfqSales = RfqSales::where('rfqSaleCode', $rfqSaleCode)->get();
        
        foreach ($rfqSales as $rfqSale) {
            $productID = $rfqSale->productID;

            $product = Products::where('id', $productID)->first();

            if($rfqSale->rfqSaleStatus == 'Done'){
                $product->update([
                    'productStock' => $product->productStock + $rfqSale->qtySold,
                ]);
            }
        }

        RfqSales::where('rfqSaleCode', $rfqSaleCode)->delete();

        return redirect()
        ->route('rfq-sales')
        ->with('success', 'Successfully deleted request for quotation sale');
    }

    public function delivered(Request $request)
    {
        # code...
        $rfqSaleCode = $request->rfqSaleCode;

        $rfqSales = RfqSales::where('rfqSaleCode', $rfqSaleCode)->get();

        foreach ($request->productID as $index => $productID) {
            $rfqSale = $rfqSales->where('productID', $productID)->first();

            if ($rfqSale) {
                $rfqSale->update([
                    'rfqSaleStatus' => 'Deliver',
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()
        ->route('rfq-sales')
        ->with('success', 'Successfully deliver request for quotation sale');
    }

    public function confirmed(Request $request)
    {
        # code...
        // dd(request()->route()->getName());
        $rfqSaleCode = $request->rfqSaleCode;

        $rfqSales = RfqSales::where('rfqSaleCode', $rfqSaleCode)->get();

        foreach ($request->productID as $index => $productID) {
            $rfqSale = $rfqSales->where('productID', $productID)->first();
            $product = Products::where('id', $productID)->first();

            if ($rfqSale && $product) {
                $rfqSale->update([
                    'rfqSaleStatus' => 'Done',
                    'updated_at' => now(),
                ]);
                $product->update([
                    'productStock' => $product->productStock - $request->qtySold[$index],
                ]);
            }
        }

        return redirect()
        ->route('rfq-sales')
        ->with('success', 'Successfully confirmed request for quotation sale');
    }
}
