<?php

namespace App\Http\Controllers;

use App\Models\Boms;
use App\Models\Products;
use App\Models\Materials;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BomsController extends Controller
{
    //
    public function index()
    {
        # code...
        $boms = Boms::select('bomCode', 'productID', 'qtyProduct')
                    ->selectRaw('SUM(unitPrice) as price')
                    ->orderBy('bomCode')
                    ->groupBy('bomCode', 'productID', 'qtyProduct')
                    ->get();

        return view('menu.manufacturing.bom.bom', compact('boms'));
    }

    public function create()
    {
        # code...
        $products = Products::get();
        $materials = Materials::get();

        return view('menu.manufacturing.bom.formbom', compact('products', 'materials'));
    }

    public function edit(Request $request)
    {
        # code...
        $bomCode = $request->bomCode;
        $bom = Boms::where('bomCode', $bomCode)->first();
        
        $boms = Boms::where('bomCode', $bomCode)->get();
        $products = Products::get();
        $materials = Materials::get();

        return view('menu.manufacturing.bom.formbom', compact('products', 'materials', 'boms', 'bom'));
    }

    public function preview(Request $request)
    {
        # code...
        $bomCode = $request->bomCode;
        $bom = Boms::where('bomCode', $bomCode)->first();
        
        $boms = Boms::where('bomCode', $bomCode)->get();
        $products = Products::get();
        $materials = Materials::get();

        return view('menu.manufacturing.bom.formbom', compact('products', 'materials', 'boms', 'bom'));
    }

    public function insert(Request $request)
    {
        # code...
        $request->validate([
            'productID' => 'required|exists:products,id',
            'materialID.*' => 'required|exists:materials,id',
            'qtyMaterial.*' => 'required|numeric|max:9999999999',
        ]);

        $lastBomRecord = Boms::orderBy('bomCode', 'desc')->first();
        $count = $lastBomRecord ? $lastBomRecord->bomCode : 'PRD/BOM/0000';
        
        $lastBom = (int) substr($count, 8);
        $bomCode = 'PRD/BOM/' . str_pad($lastBom + 1, 4, '0', STR_PAD_LEFT);

        $bomData = [];
        foreach ($request->materialID as $index => $materialID) {
            
            $material = Materials::where('id', $materialID)->first();

            $materialCost = $material->materialCost;

            $unitPrice = ($material->materialCost * $request->qtyMaterial[$index]);

            $bomData[] = [
                'id' => Str::uuid(),
                'bomCode' => $bomCode,
                'productID' => $request->productID,
                'qtyProduct' => 1,
                'materialID' => $materialID,
                'qtyMaterial' => $request->qtyMaterial[$index],
                'cost' => $materialCost,
                'unitPrice' => $unitPrice,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Boms::insert($bomData);

        return redirect()
        ->route('bom')
        ->with('success', 'Successfully created bills of materials');
    }

    public function update(Request $request)
    {
        $request->validate([
            'productID' => 'required|exists:products,id',
            'materialID.*' => 'required|exists:materials,id',
            'qtyMaterial.*' => 'required|numeric|max:9999999999',
        ]);

        $bomCode = $request->bomCode;

        $bom = Boms::where('bomCode', $bomCode)->first();
        $created_at = $bom->created_at;

        $bomData = [];
        foreach ($request->materialID as $index => $materialID) {

            $material = Materials::where('id', $materialID)->first();

            $materialCost = $material->materialCost;

            $unitPrice = ($material->materialCost * $request->qtyMaterial[$index]);

            $bomData[] = [
                'id' => Str::uuid(),
                'bomCode' => $bomCode,
                'productID' => $request->productID,
                'qtyProduct' => 1,
                'materialID' => $materialID,
                'qtyMaterial' => $request->qtyMaterial[$index],
                'cost' => $materialCost,
                'unitPrice' => $unitPrice,
                'created_at' => $created_at,
                'updated_at' => now(),
            ];
        }

        Boms::where('bomCode', $bomCode)->delete();
        Boms::insert($bomData);

        return redirect()
            ->route('bom')
            ->with('success', 'Successfully updated bills of materials');
    }

    public function delete(Request $request)
    {
        # code...
        $bomCode = $request->bomCode;
        Boms::where('bomCode', $bomCode)->delete();

        return redirect()
        ->route('bom')
        ->with('success', 'Successfully deleted bills of materials');
    }
}
