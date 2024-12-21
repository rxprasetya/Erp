<?php

namespace App\Http\Controllers;

use App\Models\Vendors;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class VendorsController extends Controller
{
    //
    public function index()
    {
        # code...
        $vendors = Vendors::get();
        
        return view('menu.purchase.vendor.vendor', compact('vendors'));
    }

    public function create()
    {
        # code...
        return view('menu.purchase.vendor.formvendor');
    }

    public function edit($id)
    {
        # code...
        $vendors = Vendors::find($id);

        return view('menu.purchase.vendor.formvendor', compact('vendors'));
    }

    public function insert(Request $request)
    {
        # code...
        $request->validate([
            'name' => 'required|min:2|max:32',
            'email' => 'required|min:1|max:32',
            'mobile' => 'required|max:13',
            'address' => 'required',
        ]);

        $vendors = Vendors::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
        ]);

        return redirect()
        ->route('vendor')
        ->with('success', 'Successfully created vendor');
    }

    public function update(Request $request, $id)
    {
        # code...
        $request->validate([
            'name' => 'required|min:2|max:32',
            'email' => 'required|min:1|max:32',
            'mobile' => 'required|max:13',
            'address' => 'required',
        ]);

        $vendors = Vendors::find($id);
        $vendors->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
        ]);
        
        return redirect()
        ->route('vendor')
        ->with('success', 'Successfully updated vendor');
    }

    public function delete($id)
    {
        # code...
        $vendors = Vendors::find($id);
        $vendors->delete();

        return redirect()
        ->route('vendor')
        ->with('success', 'Successfully deleted vendor');
    }
}
