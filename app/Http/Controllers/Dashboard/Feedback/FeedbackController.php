<?php

namespace App\Http\Controllers\Dashboard\Feedback;

use App\Feedback;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{

    public function store(Request $request)
    {
        //validate feedback...
        $request->validate([
            'feedback' => 'required|string|max:1000',
        ]);

        if ($request->has('product_id')) {

            //create feedback...
            $feedback = DB::table('Feedbacks')->insert([
                'feedback'   => $request->input('feedback'),
                'product_id' => $request->input('product_id'),
                'created_at' =>now(),'updated_at' =>now(),
            ]);

            //redirect to all feedback...
            session()->flash('status', "success");
            session()->flash('text', "Feedback has been added successfully.");
            return redirect()->route('products.show', ['product' => $request->input('product_id'), 'tabs' => 'feedbacks']);
        }
        return redirect()->back();

    }

    public function update(Request $request, $id)
    {
        //validate Feedback...
        $request->validate([
            'feedback' => 'required|string|max:1000',
        ]);

        if ($request->has('product_id')) {

            //update Feedback...
            $feedback = DB::table('feedbacks')->where('id', $id)->update([
                'feedback'   => $request->input('feedback'),
                'product_id' => $request->input('product_id'),
                'updated_at' => now(),
            ]);

            //redirect to all Feedback...
            session()->flash('status', "success");
            session()->flash('text', "Feedback has been updated successfully.");
            return redirect()->route('products.show', ['product' => $request->input('product_id'), 'tabs' => 'feedbacks']);
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        if (request()->ajax()) {
            if (DB::table('feedbacks')->where('id', $id)->delete()) {
                session()->flash('status', "success");
                session()->flash('text', "Feedback has been deleted successfully.");
                return response()->json(['status' => 'success', 'message' => 'Feedback has been deleted successfully.']);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Http request']);
    }

}
