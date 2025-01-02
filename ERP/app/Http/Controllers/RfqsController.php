<?php

namespace App\Http\Controllers;

use App\Models\Rfqs;
use App\Models\Vendors;
use App\Models\Materials;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\OrderMaterials;

class RfqsController extends Controller
{
    //
    public function index()
    {
        # code...
        $rfqs = Rfqs::select('rfqCode', 'vendorID', 'rfqStatus')
                    ->selectRaw('SUM(totalOrder) as total')
                    ->orderBy('rfqCode')
                    ->groupBy('rfqCode', 'vendorID', 'rfqStatus')
                    ->get();

        return view('menu.purchase.rfq.rfq', compact('rfqs'));
    }

    public function create()
    {
        # code...
        $vendors = Vendors::get();
        $materials = Materials::get();
        $date = now()->setTimezone('Asia/Jakarta')->format('Y-m-d');

        return view('menu.purchase.rfq.formrfq', compact('vendors', 'materials', 'date'));
    }

    public function edit(Request $request)
    {
        # code...
        $rfqCode = $request->rfqCode;
        $rfq = Rfqs::where('rfqCode', $rfqCode)->first();


        $rfqs = Rfqs::where('rfqCode', $rfqCode)->get();
        $vendors = Vendors::get();
        $materials = Materials::get();

        return view('menu.purchase.rfq.formrfq', compact('rfqs','rfq','vendors', 'materials'));
    }

    public function preview(Request $request)
    {
        # code...
        $rfqCode = $request->rfqCode;
        $rfq = Rfqs::where('rfqCode', $rfqCode)->first();


        $rfqs = Rfqs::where('rfqCode', $rfqCode)->get();
        $vendors = Vendors::get();
        $materials = Materials::get();

        return view('menu.purchase.rfq.formrfq', compact('rfqs','rfq','vendors', 'materials'));
    }

    public function insert(Request $request)
    {
        # code...
        $request->validate([
            'vendorID' => 'required',
            'orderDate' => 'required',
            'materialID.*' => 'required|exists:materials,id',
            'qtyOrder.*' => 'required|numeric|max:9999999999',
            'priceOrder.*' => 'required|numeric|max:9999999999',
            'totalOrder.*' => 'required|numeric|max:9999999999',
        ]);

        $lastRfqRecord = Rfqs::orderBy('rfqCode', 'desc')->first();
        $count = $lastRfqRecord ? $lastRfqRecord->rfqCode : 'RFQ/ORD/0000';
        
        $lastRfq = (int) substr($count, 8);
        $rfqCode = 'RFQ/ORD/' . str_pad($lastRfq + 1, 4, '0', STR_PAD_LEFT);

        $rfqData = [];
        foreach ($request->materialID as $index => $materialID) {
            $rfqData[] = [
                'id' => Str::uuid(),
                'rfqCode' => $rfqCode,
                'vendorID' => $request->vendorID,
                'orderDate' => $request->orderDate,
                'materialID' => $materialID,
                'qtyOrder' => $request->qtyOrder[$index],
                'priceOrder' => $request->priceOrder[$index],
                'totalOrder' => $request->totalOrder[$index],
                'rfqStatus' => 'Request',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Rfqs::insert($rfqData);

        return redirect()
        ->route('rfq')
        ->with('success', 'Successfully created request for quotation');
    }

    public function update(Request $request)
    {
        $request->validate([
            'vendorID' => 'required',
            'orderDate' => 'required|date',
            'materialID.*' => 'required|exists:materials,id',
            'qtyOrder.*' => 'required|numeric|max:9999999999',
            'priceOrder.*' => 'required|numeric|max:9999999999',
            'totalOrder.*' => 'required|numeric|max:9999999999',
        ]);

        $rfqCode = $request->rfqCode;

        $rfq = Rfqs::where('rfqCode', $rfqCode)->first();
        $created_at = $rfq->created_at;

        $rfqData = [];
        foreach ($request->materialID as $index => $materialID) {
            $rfqData[] = [
                'id' => Str::uuid(),
                'rfqCode' => $rfqCode,
                'vendorID' => $request->vendorID,
                'orderDate' => $request->orderDate,
                'materialID' => $materialID,
                'qtyOrder' => $request->qtyOrder[$index],
                'priceOrder' => $request->priceOrder[$index],
                'totalOrder' => $request->totalOrder[$index],
                'rfqStatus' => 'Request',
                'created_at' => $created_at,
                'updated_at' => now(),
            ];
        }

        Rfqs::where('rfqCode', $rfqCode)->delete();
        Rfqs::insert($rfqData);

        return redirect()
            ->route('rfq')
            ->with('success', 'Successfully updated request for quotation');
    }

    public function delete(Request $request)
    {
        # code...
        $rfqCode = $request->rfqCode;
        $rfqs = Rfqs::where('rfqCode', $rfqCode)->get();
        
        foreach ($rfqs as $rfq) {
            $materialID = $rfq->materialID;

            $material = Materials::where('id', $materialID)->first();

            if($rfq->rfqStatus == 'Done'){
                $material->update([
                    'materialStock' => $material->materialStock - $rfq->qtyOrder,
                ]);
            }
        }

        Rfqs::where('rfqCode', $rfqCode)->delete();

        return redirect()
        ->route('rfq')
        ->with('success', 'Successfully deleted request for quotation');
    }

    public function validated(Request $request)
    {
        # code...
        $rfqCode = $request->rfqCode;

        $rfqs = Rfqs::where('rfqCode', $rfqCode)->get();

        foreach ($request->materialID as $index => $materialID) {
            $rfq = $rfqs->where('materialID', $materialID)->first();

            if ($rfq) {
                $rfq->update([
                    'rfqStatus' => 'Purchase Order',
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()
        ->route('rfq')
        ->with('success', 'Successfully validated request for quotation');
    }

    public function confirmed(Request $request)
    {
        # code...
        // dd(request()->route()->getName());
        $rfqCode = $request->rfqCode;

        $rfqs = Rfqs::where('rfqCode', $rfqCode)->get();

        foreach ($request->materialID as $index => $materialID) {
            $rfq = $rfqs->where('materialID', $materialID)->first();
            $material = Materials::where('id', $materialID)->first();

            if ($rfq && $material) {
                $rfq->update([
                    'rfqStatus' => 'Done',
                    'updated_at' => now(),
                ]);
                $material->update([
                    'materialStock' => $material->materialStock + $request->qtyOrder[$index],
                ]);
            }
        }

        return redirect()
        ->route('rfq')
        ->with('success', 'Successfully confirmed request for quotation');
    }

    public function getCost(Request $request)
    {
        # code...
        $materialID = $request->input('materialID');

        $materialCost = Materials::where('id', $materialID)->first()->materialCost;

        return response()->json(compact('materialCost'));
    }
}
