<?php

namespace App\Http\Controllers\Dashboard\Comment;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        //validate comment...
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        if ($request->has('product_id')) {

            //create comment...
            $comment       = DB::table('comments')->insert([
                'comment' => $request->input('comment'),
                'product_id' => $request->input('product_id'),
                'created_at' =>now(),'updated_at' =>now(),
            ]);

            //redirect to all comment...
            session()->flash('status', "success");
            session()->flash('text', "Comment has been added successfully.");
            return redirect()->route('products.show',['product'=>$request->input('product_id'),'tabs'=>'comments']);
        }
        return redirect()->back();

    }

    public function update(Request $request, $id)
    {
        //validate comment...
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        if ($request->has('product_id')) {

            //update comment...
            $comment       = DB::table('comments')->where('id',$id)->update([
                'comment' => $request->input('comment'),
                'product_id' => $request->input('product_id'),
                'updated_at' =>now(),
            ]);

            //redirect to all comment...
            session()->flash('status', "success");
            session()->flash('text', "Comment has been updated successfully.");
            return redirect()->route('products.show',['product'=>$request->input('product_id'),'tabs'=>'comments']);
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        if (request()->ajax()) {
            if (DB::table('comments')->where('id',$id)->delete()) {
                session()->flash('status', "success");
                session()->flash('text', "Comment has been deleted successfully.");
                return response()->json(['status' => 'success', 'message' => 'Comment has been deleted successfully.']);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Http request']);
    }


}
