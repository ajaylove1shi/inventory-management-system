<?php

namespace App\Http\Controllers\Dashboard\Variation;

use App\Http\Controllers\Controller;
use App\Variation;
use DB;
use Illuminate\Http\Request;

class VariationController extends Controller
{

    public function store(Request $request)
    {
        //validate attribute value...
        $request->validate([
            'sku'             => 'required|string|max:255',
            'price'           => 'required|string|max:255',
            'attribute'       => 'required|string|max:255',
            'attribute_value' => 'required|string|max:255',
        ]);

        if ($request->has('product_id')) {

            //create product skus...
            $product_skus = DB::table('product_skus')->insertGetId([
                'sku'        => $request->input('sku'),
                'price'      => $request->input('price'),
                'product_id' => $request->input('product_id'),
                'created_at' =>now(),'updated_at' =>now(),
            ]);

            //create sku value...
            $sku_values = DB::table('sku_values')->insert([
                'sku_id'       => $product_skus,
                'value_id'     => $request->input('attribute_value'),
                'attribute_id' => $request->input('attribute'),
                'product_id'   => $request->input('product_id'),
                'created_at' =>now(),'updated_at' =>now(),
            ]);

            //redirect to all attribute value...
            session()->flash('status', "success");
            session()->flash('text', "Variation has been added successfully.");
            return redirect()->route('products.show', ['product' => $request->input('product_id'), 'tabs' => 'variations']);
        }
        return redirect()->back();

    }

    public function update(Request $request, $id)
    {
       //validate attribute value...
        $request->validate([
            'sku'             => 'required|string|max:255',
            'price'           => 'required|string|max:255',
            'attribute'       => 'required|string|max:255',
            'attribute_value' => 'required|string|max:255',
        ]);


        if ($request->has('product_id')) {

            //delete old details first...
            DB::table('product_skus')->where('id', $id)->delete();

            //create product skus...
            $product_skus = DB::table('product_skus')->insertGetId([
                'sku'        => $request->input('sku'),
                'price'      => $request->input('price'),
                'product_id' => $request->input('product_id'),
                'created_at' =>now(),'updated_at' =>now(),
             ]);

            //create sku value...
            $sku_values = DB::table('sku_values')->insert([
                'sku_id'       => $product_skus,
                'value_id'     => $request->input('attribute_value'),
                'attribute_id' => $request->input('attribute'),
                'product_id'   => $request->input('product_id'),
                'created_at' =>now(),'updated_at' =>now(),
            ]);

            //redirect to all attribute value...
            session()->flash('status', "success");
            session()->flash('text', "Variation has been updated successfully.");
            return redirect()->route('products.show', ['product' => $request->input('product_id'), 'tabs' => 'variations']);
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        if (request()->ajax()) {
            if (DB::table('product_skus')->where('id', $id)->delete()) {
                session()->flash('status', "success");
                session()->flash('text', "Variation has been deleted successfully.");
                return response()->json(['status' => 'success', 'message' => 'Variation has been deleted successfully.']);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Http request']);
    }

}
