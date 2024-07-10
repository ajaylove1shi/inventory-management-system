<?php

namespace App\Http\Controllers\Dashboard\Attribute;

use App\Attribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class AttributeController extends Controller
{

    public function store(Request $request)
    {
        //validate Attribute...
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($request->has('product_id')) {

            //create Attribute...
            $attribute       = DB::table('attributes')->insert([
                'name' => $request->input('name'),
                'product_id' => $request->input('product_id'),
                'created_at' =>now(),'updated_at' =>now(),
            ]);

            //redirect to all Attribute...
            session()->flash('status', "success");
            session()->flash('text', "Attribute has been added successfully.");
            return redirect()->route('products.show',['product'=>$request->input('product_id'),'tabs'=>'attributes']);
        }
        return redirect()->back();

    }

    public function update(Request $request, $id)
    {
        //validate Attribute...
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($request->has('product_id')) {

            //update Attribute...
            $attribute       = DB::table('attributes')->where('id',$id)->update([
                'name' => $request->input('name'),
                'product_id' => $request->input('product_id'),
                'updated_at' =>now(),
            ]);

            //redirect to all Attribute...
            session()->flash('status', "success");
            session()->flash('text', "Attribute has been updated successfully.");
            return redirect()->route('products.show',['product'=>$request->input('product_id'),'tabs'=>'attributes']);
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        if (request()->ajax()) {
            if (DB::table('attributes')->where('id',$id)->delete()) {
                session()->flash('status', "success");
                session()->flash('text', "Attribute has been deleted successfully.");
                return response()->json(['status' => 'success', 'message' => 'Attribute has been deleted successfully.']);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Http request']);
    }

    public function attributeValues(Request $request)
    {
        $attribute_values = DB::table('attribute_values')->where('attribute_id', $request->attribute)->pluck('name','id');

        $option = '<option value=""> -- Select Value --  </option>';
        if(!empty($attribute_values)){
            foreach($attribute_values as $key => $value){
                $option .= '<option value="' .$key.'"> '.$value.'</option>';
            }
        }
        return response()->json(['status' => 'success', 'message' => 'Attribute has been loaded successfully.','option' => $option]);
    }

}
