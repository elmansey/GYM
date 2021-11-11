<?php

namespace App\Http\Controllers\API\products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\facades\Validator;
class productController extends Controller
{

    public function index(){

    }

    public function store(Request $request){


        $validator = validator::make($request->all(), [

            'product_name' => 'required' ,
            'product_price' => 'required' ,
            'product_img' => 'required' ,
            'Production_Date' => 'required|date' ,
            'Expiry_date' => 'required|date|after_or_equal:Production_Date' ,
            'Product_Quantity' => 'required'
        ]);



        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()]);
        }






    }

    public function update(Request $request,$id){

    }

    public function destroy($id){


    }


}
