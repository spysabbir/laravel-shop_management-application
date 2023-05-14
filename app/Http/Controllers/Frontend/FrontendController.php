<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Contact_message;
use App\Models\Customer;
use App\Models\Default_setting;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 'Active')->get();
        $brands = Brand::where('status', 'Active')->get();
        $products = Product::where('status', 'Active')->latest()->get();
        $default_setting = Default_setting::first();
        return view('frontend.index', compact('categories', 'brands', 'products', 'default_setting'));
    }
    public function contactUs ()
    {
        $default_setting = Default_setting::first();
        return view('frontend.contact', compact('default_setting'));
    }
    public function contactMessageSend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            Contact_message::insert([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'subject' => $request->subject,
                'message' => $request->message,
                'created_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Contact store successfully.',
            ]);
        }
    }
}
