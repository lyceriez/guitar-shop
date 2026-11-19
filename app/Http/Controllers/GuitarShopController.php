<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Guitar;
use App\Models\GuitarSpecification;
use App\Models\Customer;

class GuitarShopController extends Controller
{
    public function dashboard()
    {
        $brands = Brand::with('guitars')->get();

        $guitars = Guitar::with([
            'brand',
            'specification',
            'customers'
        ])->get();

        $specifications = GuitarSpecification::with('guitar')->get();

        $customers = Customer::with('guitars')->get();

        return view('dashboard', compact(
            'brands',
            'guitars',
            'specifications',
            'customers'
        ));
    }
    public function storeBrand(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        Brand::create([
            'name' => $request->name,
            'country' => $request->country,
        ]);

        return redirect('/')
            ->with('success', 'Brand added successfully!');
    }
    public function storeGuitar(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        Guitar::create([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'model' => $request->model,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
        ]);

        return redirect('/')->with('success', 'Guitar added successfully!');
    }
    public function storeSpecification(Request $request)
    {
        $request->validate([
            'guitar_id' => 'required|exists:guitars,id|unique:guitar_specifications,guitar_id',
            'body_material' => 'required|string|max:255',
            'pickup_type' => 'required|string|max:255',
            'number_of_strings' => 'required|integer|min:1',
            'color' => 'required|string|max:255',
        ]);

        GuitarSpecification::create([
            'guitar_id' => $request->guitar_id,
            'body_material' => $request->body_material,
            'pickup_type' => $request->pickup_type,
            'number_of_strings' => $request->number_of_strings,
            'color' => $request->color,
        ]);

        return redirect('/')->with('success', 'Specification added successfully!');
    }
    public function storeCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect('/')->with('success', 'Customer added successfully!');
    }
    public function storePurchase(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'guitars' => 'required|array|min:1',
            'guitars.*' => 'required|exists:guitars,id',
            'purchase_date' => 'required|date',
        ]);

        $customer = Customer::findOrFail($request->customer_id);

        foreach ($request->guitars as $guitarId) {
            $customer->guitars()->attach($guitarId, [
                'purchase_date' => $request->purchase_date,
            ]);
        }

        return redirect('/')->with('success', 'Purchase saved successfully!');
    }
}