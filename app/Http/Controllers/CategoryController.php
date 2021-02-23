<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Auth;
use Carbon\Carbon;
use Image;
use App\Rules\FindOutNumberRule;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function index() {
    	return view('admin.category.index',[
            'categories' => Category::all(),
    		'deleted_categories' => Category::onlyTrashed()->get()
    	]);
    }

    function storeCategory(Request $request) {
    	// print_r($request->category_name);
    	$request->validate([
    		'category_name' => ['required','unique:categories,category_name', new FindOutNumberRule],
            'category_photo' => 'image',

    	]);

    	$category_id = Category::insertGetId([
    		'category_name' 	   => $request->category_name,
    		'category_description' => $request->category_description,
    		'user_id' => Auth::id(),
    		'created_at' => Carbon::now()
    	]);

        if ($request->hasFile('category_photo')) {
            // echo $category_id;
            $uploaded_photo = $request->file('category_photo');
            $photo_name = $category_id.".".$uploaded_photo->getClientOriginalExtension($uploaded_photo);
            $new_photo_location = 'public/dashboard_asset/photo/category_photo/'.$photo_name;

            Image::make($uploaded_photo)->resize(200,200)->save(base_path($new_photo_location), 50);
            Category::find($category_id)->update([
                'cat_photo' => $photo_name
            ]);
            
        }
        return back()->with('image_upload_status', 'Category created successfully!');
    }

    function destroyCategory($category_id) {
    	// echo $category_id;
    	Category::find($category_id)->delete();
    	return back()->with('delete_status', 'Category deleted successfully.');
    }

    function showCategory($category_id) {
        // echo $category_id;
        return view('admin.category.edit',[
            'category_info' => Category::find($category_id)
        ]);
    }

    function editCategory(Request $request) {
        // echo Category::find($request->category_id)->cat_photo;
        $category_id = $request->category_id;
        $request->validate([
            'category_name' => 'required|alpha|unique:categories,category_name,' .$request->category_id,
            'category_description' => 'required',
        ]);

        Category::where('id', '=', $request->category_id)->update([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description,
        ]);

        if ($request->hasFile('category_photo')) {
            // echo "ase";
            // echo $category_id;
            if (Category::find($request->category_id)->cat_photo != 'default.png') {
                $deleted_photo_location = 'public/dashboard_asset/photo/category_photo/'.Category::find($request->category_id)->cat_photo;
                unlink(base_path($deleted_photo_location));
            }
            $uploaded_photo = $request->file('category_photo');
            $photo_name = $category_id.".".$uploaded_photo->getClientOriginalExtension($uploaded_photo);
            $new_photo_location = 'public/dashboard_asset/photo/category_photo/'.$photo_name;

            Image::make($uploaded_photo)->resize(200,200)->save(base_path($new_photo_location), 50);
            Category::find($category_id)->update([
                'cat_photo' => $photo_name
            ]);
            
        }
        return redirect('add/category')->with('update_status', 'Category updated successfully.');
    }

    function restoreCategory($category_id)
    {
        // echo $category_id;
        Category::withTrashed()->find($category_id)->restore();
        return back()->with('restore_status', 'Category restore successfully.');
    }

    function forcedeleteCategory($category_id) 
    {
        // echo $category_id;
        Category::withTrashed()->find($category_id)->forceDelete();
        return back()->with('forcedelete_status', 'Your category permently deleted successfully.');
    }

    function markDeleteCategory(Request $request) {
        if (isset($request->category_id)) {
            foreach ($request->category_id as $cat_id) {
                Category::find($cat_id)->delete();
            }
            return back()->with('delete_status', 'Category deleted successfully.');
        } else {
            return back()->with('deleted_status', 'Please select a value for delete.');
        }
        
    } 
}
