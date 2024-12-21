<?php

namespace App\Http\Controllers;

use App\Models\Materials;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MaterialsController extends Controller
{
    //
    public function index()
    {
        # code...
        $materials = Materials::all();

        return view('menu.material.material', compact('materials'));
    }

    public function create()
    {
        # code...
        return view('menu.material.formmaterial');
    }

    public function edit($id)
    {
        # code...
        $materials = Materials::find($id);

        return view('menu.material.formmaterial', compact('materials'));
    }

    public function insert(Request $request)
    {
        # code...
        $request->validate([
            'materialCode' => 'required|min:1|max:4',
            'materialName' => 'required|min:1|max:32',
            'materialCost' => 'required|min:1|max:10',
            'materialStock' => 'max:10',
            'unit' => 'required|min:1|max:4',
        ]);

        $materials = Materials::create([
            'id' => Str::uuid(),
            'materialCode' => $request->materialCode,
            'materialName' => $request->materialName,
            'materialCost' => $request->materialCost,
            'materialStock' => 0,
            'unit' => $request->unit,
        ]);

        return redirect()
        ->route('material')
        ->with('success', 'Successfully created material');
    }

    public function update(Request $request, $id)
    {
        # code...
        $request->validate([
            'materialCode' => 'required|min:1|max:4',
            'materialName' => 'required|min:1|max:32',
            'materialCost' => 'required|min:1|max:10',
            'materialStock' => 'max:10',
            'unit' => 'required|min:1|max:4',
        ]);

        $materials = Materials::find($id);

        $materials->update([
            'materialCode' => $request->materialCode,
            'materialName' => $request->materialName,
            'materialCost' => $request->materialCost,
            'materialStock' => 0,
            'unit' => $request->unit,
        ]);
        
        return redirect()
        ->route('material')
        ->with('success', 'Successfully updated material');
    }

    public function delete($id)
    {
        # code...
        $materials = Materials::find($id);
        $materials->delete();

        return redirect()
        ->route('material')
        ->with('success', 'Successfully deleted material');
    }
}
