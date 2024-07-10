<?php

namespace App\Http\Controllers\Dashboard\AttributeValue;

use App\AttributeValue;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{

    public function store(Request $request)
    {
        //validate attribute value...
        $request->validate([
            'name'      => 'required|string|max:255',
            'attribute' => 'required|string|max:255',
        ]);

        if ($request->has('product_id')) {

            //create attribute value...
            $attribute_value = DB::table('attribute_values')->insert([
                'name'         => $request->input('name'),
                'attribute_id' => $request->input('attribute'),
                'product_id'   => $request->input('product_id'),
                'created_at' =>now(),'updated_at' =>now(),
            ]);

            //redirect to all attribute value...
            session()->flash('status', "success");
            session()->flash('text', "Attribute value has been added successfully.");
            return redirect()->route('products.show', ['product' => $request->input('product_id'), 'tabs' => 'attribute-values']);
        }
        return redirect()->back();

    }

    public function update(Request $request, $id)
    {
        //validate attribute value...
        $request->validate([
            'name'      => 'required|string|max:255',
            'attribute' => 'required|string|max:255',
        ]);

        if ($request->has('product_id')) {

            //update attribute value...
            $attribute_value = DB::table('attribute_values')->where('id', $id)->update([
                'name'         => $request->input('name'),
                'attribute_id' => $request->input('attribute'),
                'product_id'   => $request->input('product_id'),
                'updated_at' =>now(),
            ]);

            //redirect to all attribute value...
            session()->flash('status', "success");
            session()->flash('text', "Attribute value has been updated successfully.");
            return redirect()->route('products.show', ['product' => $request->input('product_id'), 'tabs' => 'attribute-values']);
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        if (request()->ajax()) {
            if (DB::table('attribute_values')->where('id', $id)->delete()) {
                session()->flash('status', "success");
                session()->flash('text', "Attribute value has been deleted successfully.");
                return response()->json(['status' => 'success', 'message' => 'Attribute value has been deleted successfully.']);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Http request']);
    }

}
