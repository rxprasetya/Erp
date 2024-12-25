<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    //
    public function index()
    {
        # code...
        $customers = Customers::get();
        
        return view('menu.sale.customer.customer', compact('customers'));
    }

    public function create()
    {
        # code...
        return view('menu.sale.customer.formcustomer');
    }

    public function edit($id)
    {
        # code...
        $customers = Customers::find($id);

        return view('menu.sale.customer.formcustomer', compact('customers'));
    }

    public function insert(Request $request)
    {
        # code...
        $request->validate([
            'customerName' => 'required|min:2|max:32',
            'customerEmail' => 'required|min:1|max:32',
            'customerMobile' => 'required|max:13',
            'customerAddress' => 'required',
        ]);

        $customers = Customers::create([
            'id' => Str::uuid(),
            'customerName' => $request->customerName,
            'customerEmail' => $request->customerEmail,
            'customerMobile' => $request->customerMobile,
            'customerAddress' => $request->customerAddress,
        ]);

        return redirect()
        ->route('customer')
        ->with('success', 'Successfully created customer');
    }

    public function update(Request $request, $id)
    {
        # code...
        $request->validate([
            'customerName' => 'required|min:2|max:32',
            'customerEmail' => 'required|min:1|max:32',
            'customerMobile' => 'required|max:13',
            'customerAddress' => 'required',
        ]);

        $customers = Customers::find($id);
        $customers->update([
            'customerName' => $request->customerName,
            'customerEmail' => $request->customerEmail,
            'customerMobile' => $request->customerMobile,
            'customerAddress' => $request->customerAddress,
        ]);
        
        return redirect()
        ->route('customer')
        ->with('success', 'Successfully updated customer');
    }

    public function delete($id)
    {
        # code...
        $customers = Customers::find($id);
        $customers->delete();

        return redirect()
        ->route('customer')
        ->with('success', 'Successfully deleted customer');
    }
}
