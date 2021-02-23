<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\ProductMultiplePhoto;
use Carbon\Carbon;
use Image;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkrole');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        return view('products.index', [
            'categories' => Category::all(),
            'products' => Product::with('withCategoryTable')->with('ProductMultiplePhoto')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug_link = Str::slug($request->product_name).'-'.Str::random(5);
        $request->validate([
            'product_photo' => 'image',
        ]);
        // print_r($request->except('_token'));
        $porduct_id = Product::insertGetId($request->except('_token','product_photo','product_multiple_photos') + [
            'created_at' => Carbon::now(),
            'slug' => $slug_link
        ]);

        if ($request->hasFile('product_photo')) {
            $uploaded_photo = $request->file('product_photo');
            $photo_name = $porduct_id.".".$uploaded_photo->getClientOriginalExtension($uploaded_photo);
            $new_photo_location = 'public/dashboard_asset/photo/product_photo/'.$photo_name;

            Image::make($uploaded_photo)->resize(500,385)->save(base_path($new_photo_location), 50);
            Product::find($porduct_id)->update([
                'product_photo' => $photo_name
            ]);
        }

        if ($request->hasFile('product_multiple_photos')) {
            $flag = 1;
            foreach ($request->file('product_multiple_photos') as $single_photo) {
                $uploaded_photo = $single_photo;
                $photo_name = $porduct_id.'-'.$flag++.".".$uploaded_photo->getClientOriginalExtension();

                $new_photo_location = 'public/dashboard_asset/photo/multiple_photos/'.$photo_name;

                Image::make($uploaded_photo)->resize(600,622)->save(base_path($new_photo_location), 50);
                ProductMultiplePhoto::insert([
                    'product_id' => $porduct_id,
                    'product_multiple_photos' => $photo_name,
                    'created_at' => Carbon::now()
                ]);

            }
        }
        return back()->with('created_status', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('products.edit', [
            'categories' => Category::all(),
            'products' => Product::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Product::find($id)->update($request->except('_token', '_method'));
        return redirect('product')->with('updated_status', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return back()->with('delete_status', "Product deleted successfully.");
    }
}
