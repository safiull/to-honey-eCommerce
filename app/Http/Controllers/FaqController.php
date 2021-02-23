<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FAQ;
use Carbon\Carbon;

class FaqController extends Controller
{
    public function index() 
    {
    	return view('faq.index',[
    		'faqs' => FAQ::all()
    	]);
    } 

    public function addFaq(Request $request) 
    {
    	FAQ::insert($request->except('_token') + [
    		'created_at' => Carbon::now(),
    	]);

    	return back()->with('insert-faq','FAQ inserted successfully.');
    }

    public function destroy($id) 
    {
    	FAQ::find($id)->delete();
        return back()->with('delete_status', "Faq deleted successfully.");
    }
}
