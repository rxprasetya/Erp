<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    //
    public function index()
    {
        # code...
        $products = Products::orderBy('productName', 'asc')->orderBy('productCode', 'asc')->get();
        
        return view('menu.product.product', compact('products'));
    }

    public function create()
    {
        # code...
        return view('menu.product.formproduct');
    }

    public function edit($id)
    {
        # code...
        $products = Products::find($id);

        return view('menu.product.formproduct', compact('products'));
    }

    public function insert(Request $request)
    {
        # code...
        $request->validate([
            'productCode' => 'required|min:1|max:4',
            'productName' => 'required|min:1|max:32',
            'productStock' => 'max:10',
            'productImage' => 'required|mimes:jpg,png,jpeg,webp,bmp',
        ]);
        
        if ($request->has('productImage')) {
            # code...
            $file = $request->file('productImage');

            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;

            $path = 'uploads/category/';
            $file->move($path, $filename);
        }

        $products = Products::create([
            'id' => Str::uuid(),
            'productCode' => $request->productCode,
            'productName' => $request->productName,
            'productStock' => 0,
            'productImage' => $path.$filename,
        ]);

        return redirect()
        ->route('product')
        ->with('success', 'Successfully created product');
    }

    public function update(Request $request, $id)
    {
        # code...
        $request->validate([
            'productCode' => 'required|min:1|max:4',
            'productName' => 'required|min:1|max:32',
            'productStock' => 'max:10',
            'productImage' => 'required|mimes:jpg,png,jpeg,webp,bmp',
        ]);

        $products = Products::find($id);

        if ($request->has('productImage')) {
            # code...
            $file = $request->file('productImage');

            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;

            $path = 'uploads/category/';
            $file->move($path, $filename);

            if (File::exists($products->productImage)) {
                # code...
                File::delete($products->productImage);
            }
        }

        $products->update([
            'productCode' => $request->productCode,
            'productName' => $request->productName,
            'productImage' => $path.$filename,
        ]);
        
        return redirect()
        ->route('product')
        ->with('success', 'Successfully updated product');
    }

    public function delete($id)
    {
        # code...
        $products = Products::find($id);

        if (File::exists($products->productImage)) {
            # code...
            File::delete($products->productImage);
        }

        $products->delete();

        return redirect()
        ->route('product')
        ->with('success', 'Successfully deleted product');
    }
}
