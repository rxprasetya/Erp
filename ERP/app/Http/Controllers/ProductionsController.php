<?php

namespace App\Http\Controllers;

use App\Models\Boms;
use App\Models\Products;
use App\Models\Materials;
use App\Models\Productions;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductionsController extends Controller
{
    //
    public function index()
    {
        # code...
        $productions = Productions::join('boms', 'productions.bomID', '=', 'boms.id')
                                ->join('products', 'boms.productID', '=', 'products.id')
                                ->select(
                                    'productions.productionCode',
                                    'productions.qtyProduction',
                                    'productions.productionDate',
                                    'productions.productionStatus',
                                    'products.productCode',
                                    'products.productName',
                                )
                                ->selectRaw('COUNT(productions.bomID) as total')
                                ->groupBy(
                                    'productions.productionCode',
                                    'productions.qtyProduction',
                                    'productions.productionDate',
                                    'productions.productionStatus',
                                    'products.productCode',
                                    'products.productName',
                                )
                                ->get();

        return view('menu.manufacturing.production.production', compact('productions'));
    }

    public function create()
    {
        # code...
        $boms = Boms::select('bomCode', 'productID', 'qtyProduct')
                    ->selectRaw('SUM(unitPrice) as price')
                    ->orderBy('bomCode')
                    ->groupBy('bomCode', 'productID', 'qtyProduct')
                    ->get();

        $date = now()->setTimezone('Asia/Jakarta')->format('Y-m-d');

        return view('menu.manufacturing.production.formproduction', compact('boms', 'date'));
    }

    public function preview(Request $request)
    {
        # code...
        $productionCode = $request->productionCode;

        $productions = Productions::where('productionCode', $productionCode)->get();

        $production = Productions::where('productionCode', $productionCode)->first();

        $boms = Boms::select('bomCode', 'productID', 'qtyProduct')
                    ->selectRaw('SUM(unitPrice) as price')
                    ->orderBy('bomCode')
                    ->groupBy('bomCode', 'productID', 'qtyProduct')
                    ->get();

        // dd($production->bom->productID);

        return view('menu.manufacturing.production.formproduction', compact('boms', 'productions', 'production'));
    }

    public function edit(Request $request)
    {
        # code...
        $productionCode = $request->productionCode;

        $productions = Productions::where('productionCode', $productionCode)->get();

        $production = Productions::where('productionCode', $productionCode)->first();

        $boms = Boms::select('bomCode', 'productID', 'qtyProduct')
                    ->selectRaw('SUM(unitPrice) as price')
                    ->orderBy('bomCode')
                    ->groupBy('bomCode', 'productID', 'qtyProduct')
                    ->get();

        return view('menu.manufacturing.production.formproduction', compact('boms', 'productions', 'production'));
    }

    public function insert(Request $request)
    {
        # code...
        $request->validate([
            'qtyProduction' => 'required|numeric|max:999999999',
            'productionDate' => 'required|date',
            'bomID' => 'required'
        ]);

        $lastProductionRecord = Productions::orderBy('productionCode', 'desc')->first();
        $count = $lastProductionRecord ? $lastProductionRecord->productionCode : 'PRD/MNO/0000';
        
        $lastProduction = (int) substr($count, 8);
        $productionCode = 'PRD/MNO/' . str_pad($lastProduction + 1, 4, '0', STR_PAD_LEFT);

        $boms = Boms::where('bomCode', $request->bomID)->get();

        foreach ($boms as $bom) {
            # code...
            Productions::create([
                'id' => Str::uuid(),
                'productionCode' => $productionCode,
                'qtyProduction' => $request->qtyProduction,
                'productionDate' => $request->productionDate,
                'bomID' => $bom->id,
                'productionStatus' => 'Request',
            ]);
        }

        return redirect()->route('production')->with('success', 'Sucessfully created production order');
    }

    public function getMaterials(Request $request)
    {
        $bomCode = $request->input('bomID'); 

        $boms = Boms::where('bomCode', $bomCode)->get();
        
        $dataBom = [];
        foreach ($boms as $bom) {
            # code...
            $dataBom[] = [
                'materialCode' => $bom->material->materialCode,
                'materialName' => $bom->material->materialName,
                'qtyMaterial' => $bom->qtyMaterial,
            ];
        }

        return response()->json(compact('dataBom'));
    }

    public function isAvailable(Request $request)
    {
        $boms = Boms::where('bomCode', $request->bomID)->get();

        foreach ($boms as $bom) {
            $material = Materials::where('id', $bom->materialID)->first();

            $materialStock = $material->materialStock;
            $toConsume = $bom->qtyMaterial;

            if ($materialStock < $toConsume) {
                return response()->json(['error' => 'Materials are not enough for bom: ' . $bom->bomCode]);
            }
        }

        return response()->json(['success' => 'Materials are available for bom: ' . $bom->bomCode]);
    }

    public function validated(Request $request)
    {
        # code...
        $productionCode = $request->productionCode;

        $productions = Productions::where('productionCode', $productionCode)->get();

        foreach ($productions as $production) {

            if ($production) {
                $production->update([
                    'productionStatus' => 'Manufacturing Order',
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()
        ->route('production')
        ->with('success', 'Successfully validated production order');
    }

    public function confirmed(Request $request)
    {
        # code...
        $productionCode = $request->productionCode;

        $productions = Productions::where('productionCode', $productionCode)->get();

        foreach ($productions as $production) {
            $productID = $production->bom->productID;
            $product = Products::where('id', $productID)->first();
            $materialID = $production->bom->materialID;
            $material = Materials::where('id', $materialID)->first();
            $materialStock = $material->materialStock;
            $qtyMaterial = $production->bom->qtyMaterial;
            $qtyProduction = $request->qtyProduction;

            if ($production && $material) {
                $production->update([
                    'productionStatus' => 'Done',
                    'updated_at' => now(),
                ]);
                $product->update([
                    'productStock'=> $request->qtyProduction,
                ]);
                $material->update([
                    'materialStock' => $materialStock - $qtyMaterial*$qtyProduction,
                ]);
            }
        }

        return redirect()
        ->route('production')
        ->with('success', 'Successfully confirmed production order');
    }

    public function update(Request $request)
    {
        # code...
        $request->validate([
            'qtyProduction' => 'required|numeric|max:999999999',
            'productionDate' => 'required|date',
            'bomID' => 'required'
        ]);

        $boms = Boms::where('bomCode', $request->bomID)->get();
        $productionCode = $request->productionCode;

        $production = Productions::where('productionCode', $productionCode)->first();
        $created_at = $production->created_at;

        $productionData = [];
        foreach ($boms as $bom) {
            # code...
            $productionData[] = [
                'id' => Str::uuid(),
                'productionCode' => $request->productionCode,
                'qtyProduction' => $request->qtyProduction,
                'productionDate' => $request->productionDate,
                'bomID' => $bom->id,
                'productionStatus' => 'Request',
                'created_at' => $created_at,
                'updated_at' => now(),
            ];
        }

        Productions::where('productionCode', $productionCode)->delete();
        Productions::insert($productionData);

        return redirect()->route('production')->with('success', 'Sucessfully updated production order');
    }

    public function delete(Request $request)
    {
        # code...
        $productionCode = $request->productionCode;
        $productions = Productions::where('productionCode', $productionCode)->get();

        foreach ($productions as $production) {
            # code...
            $productID = $production->bom->productID;
            $product = Products::where('id', $productID)->first();
            $materialID = $production->bom->materialID;
            $material = Materials::where('id', $materialID)->first();
            
            $materialStock = $material->materialStock;
            $qtyMaterial = $production->bom->qtyMaterial;
            $qtyProduction = $production->qtyProduction;

            if($production->productionStatus == 'Done'){
                $newProductStock = max(0, $product->productStock - $qtyProduction);
                $product->update([
                    'productStock' => $newProductStock,
                ]);
                $material->update([
                    'materialStock' => $materialStock + $qtyMaterial*$qtyProduction,
                ]);
            }
        }
        

        Productions::where('productionCode', $productionCode)->delete();

        return redirect()
        ->route('production')
        ->with('success', 'Successfully deleted production order');
    }

}
