<?php

namespace App\Http\Controllers\Dashboard\Product;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::with('categories')->paginate(25);
        return view('dashboard.pages.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('dashboard.pages.products.create', compact('categories'));
    }

    public function show(Request $request, $id)
    {
        $product = Product::with(['comments', 'feedbacks'])->findOrFail($id);

        $attributes       = DB::table('attributes')->where('product_id', $product->id)->get();
        $attribute_values = DB::table('attribute_values')->where('product_id', $product->id)->get();
        $variations       = DB::table('sku_values')->select('sku_values.sku_id', 'attributes.name as attribute_name', 'attribute_values.name as attribute_value_name', 'product_skus.*')
            ->join('attributes', 'sku_values.attribute_id', '=', 'attributes.id')
            ->join('attribute_values', 'sku_values.value_id', '=', 'attribute_values.id')
            ->join('product_skus', 'sku_values.sku_id', '=', 'product_skus.id')
            ->where('sku_values.product_id', $product->id)->get();
        $data = [
            'product'          => $product,
            'attributes'       => $attributes,
            'attribute_values' => $attribute_values,
            'variations'       => $variations,
        ];

        if ($request->query('action') == 'edit' && $request->query('module') == 'attribute') {
            $data['attribute'] = DB::table('attributes')->where('product_id', $product->id)->where('id', $request->query('attribute'))->first();
        }

        if ($request->query('action') == 'edit' && $request->query('module') == 'attribute-value') {
            $data['attribute_value'] = DB::table('attribute_values')->where('product_id', $product->id)->where('id', $request->query('attribute-value'))->first();
        }

        if ($request->query('action') == 'edit' && $request->query('module') == 'variations') {

            $data['variation'] = DB::table('sku_values')->select('sku_values.sku_id', 'attributes.id as attribute_id', 'attribute_values.id as attribute_value_id', 'product_skus.*')
                ->join('attributes', 'sku_values.attribute_id', '=', 'attributes.id')
                ->join('attribute_values', 'sku_values.value_id', '=', 'attribute_values.id')
                ->join('product_skus', 'sku_values.sku_id', '=', 'product_skus.id')
                ->where('sku_values.product_id', $product->id)
                ->where('sku_values.sku_id', $request->query('variations'))->first();

        }

        if ($request->query('action') == 'edit' && $request->query('module') == 'comments') {
            $data['comment'] = DB::table('comments')->where('product_id', $product->id)->where('id', $request->query('comments'))->first();
        }

        if ($request->query('action') == 'edit' && $request->query('module') == 'feedbacks') {
            $data['feedback'] = DB::table('feedbacks')->where('product_id', $product->id)->where('id', $request->query('feedbacks'))->first();
        }
        $data['get_rating_star'] = $this->get_rating_star($product->ratings);
        $data['images']          = DB::table('product_images')->where('product_id', $product->id)->pluck('image');

        return view('dashboard.pages.products.show', $data);
    }

    public function store(Request $request)
    {
        //validate product...
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'sku'         => 'required|string',
            'category'    => 'required|array',
            'category.*'  => 'required|string',
            'price'       => 'required|numeric',
            'images'      => 'required|array|min:1|max:5',
            'images.*'    => 'mimes:jpg,jpeg,png,bmp|max:20000',
        ], [
            'images.*.required' => 'Please upload an image.',
            'images.*.mimes'    => 'Only jpeg,png and bmp images are allowed.',
            'images.*.max'      => 'Sorry! Maximum allowed size for an image is 20MB.',
        ]);

        //create product...
        $product              = new Product();
        $product->name        = $request->input('name');
        $product->description = $request->input('description');
        $product->sku         = $request->input('sku');
        $product->price       = $request->input('price');
        //save product...
        if ($product->save()) {

            //upload images...
            $this->upload($request, 'images', $product->id);

            //attach category...
            $categories = $request->input('category');
            if (isset($categories)) {
                foreach ($categories as $key => $category_id) {
                    $attach_category = Category::where('id', '=', $category_id)->firstOrFail();
                    $product->categories()->attach($attach_category);
                }
            }

            //redirect to all product...
            session()->flash('status', "success");
            session()->flash('text', "Product has been added successfully.");
            return redirect()->route('products.index');
        }
    }

    public function edit($id)
    {
        $product    = Product::findOrFail($id);
        $images     = DB::table('product_images')->where('product_id', $product->id)->get();
        $categories = Category::whereNull('parent_id')->get();
        return view('dashboard.pages.products.edit', compact('images', 'product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        //validate product...
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'sku'         => 'required|string',
            'category'    => 'required|array',
            'category.*'  => 'required|string',
            'price'       => 'required|numeric',
            'images'      => 'array|min:1|max:5',
            'images.*'    => 'mimes:jpg,jpeg,png,bmp|max:20000',
        ], [
            'images.*.required' => 'Please upload an image.',
            'images.*.mimes'    => 'Only jpeg,png and bmp images are allowed.',
            'images.*.max'      => 'Sorry! Maximum allowed size for an image is 20MB.',
        ]);

        //update product...
        $product              = Product::findOrFail($id);
        $product->name        = $request->input('name');
        $product->description = $request->input('description');
        $product->sku         = $request->input('sku');
        $product->price       = $request->input('price');

        //save product...
        if ($product->save()) {

            //upload images...
            $this->upload($request, 'images', $product->id);

            //attach category...
            $product->categories()->detach(Category::all());
            $categories = $request->input('category');
            if (isset($categories)) {
                $product->categories()->sync($categories);
            } else {
                $product->categories()->sync(array());
            }

            //redirect to all product...
            session()->flash('status', "success");
            session()->flash('text', "Product has been updated successfully.");
            return redirect()->route('products.index');
        }

    }

    public function destroy($id)
    {
        if (request()->ajax()) {
            $product = Product::findOrFail($id);
            if ($product->delete()) {
                session()->flash('status', "success");
                session()->flash('text', "Product has been deleted successfully.");
                return response()->json(['status' => 'success', 'message' => 'Product has been deleted successfully.']);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Http request']);
    }

    public function ratings(Request $request)
    {
        //update product...
        $product          = Product::findOrFail($request->input('product'));
        $product->ratings = $request->input('rating');

        //save product...
        if ($product->save()) {
            session()->flash('status', "success");
            session()->flash('text', "Product rating has been updated successfully.");
            return response()->json(['status' => 'success', 'message' => 'Product rating has been updated successfully.']);
        }
        return response()->json(['status' => 'error', 'message' => 'Http request']);
    }

    protected function get_rating_star($rating = '1')
    {
        switch ($rating) {
            case '1':
                return '
                    <span class="fa fa-star" style="color: orange;"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                ';
                break;
            case '2':
                return '
                    <span class="fa fa-star" style="color: orange;"></span>
                    <span class="fa fa-star" style="color: orange;"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                ';
                break;
            case '3':
                return '
                    <span class="fa fa-star" style="color: orange;"></span>
                    <span class="fa fa-star" style="color: orange;"></span>
                    <span class="fa fa-star" style="color: orange;"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                ';
                break;
            case '4':
                return '
                    <span class="fa fa-star" style="color: orange;"></span>
                    <span class="fa fa-star" style="color: orange;"></span>
                    <span class="fa fa-star" style="color: orange;"></span>
                    <span class="fa fa-star" style="color: orange;"></span>
                    <span class="fa fa-star"></span>
                ';
                break;
            case '5':
                return '
                    <span class="fa fa-star" style="color: orange;"></span>
                    <span class="fa fa-star" style="color: orange;"></span>
                    <span class="fa fa-star" style="color: orange;"></span>
                    <span class="fa fa-star" style="color: orange;"></span>
                    <span class="fa fa-star" style="color: orange;"></span>
                ';
                break;

            default:
                return '
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                ';
                break;
        }
    }

    protected function upload(Request $request, $file_name, $id)
    {
        $insert = [];
        if ($request->hasFile($file_name)) {
            if ($files = $request->file($file_name)) {
                foreach ($files as $key => $file) {
                    $filenameWithExt = $file->getClientOriginalName();
                    $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension       = $file->getClientOriginalExtension();
                    $image_name      = time() . rand() . $key . '.' . $extension;
                    $path            = $file->storeAs('public/products', $image_name);

                    $insert[] = [
                        'image'      => $image_name,
                        'product_id' => $id,
                    ];
                }
            }
        }
        return DB::table('product_images')->insert($insert);
    }

    public function deleteImages(Request $request, $id)
    {
        if (request()->ajax()) {
            $product_images = DB::table('product_images')->select('image', 'id')->where('id', $id)->first();
            if (!empty($product_images)) {

                //delete old file...
                Storage::delete('public/products/' . $product_images->image);

                DB::table('product_images')->where('id', $id)->delete();

                session()->flash('status', "success");
                session()->flash('text', "Product image has been deleted successfully.");
                return response()->json(['status' => 'success', 'message' => 'Product image has been deleted successfully.']);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Http request']);
    }
}
