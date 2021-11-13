<?php

namespace App\Http\Controllers\API\products;

use App\Models\products;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\support\facades\Validator;

class productController extends Controller
{

    public function index()
    {

        $products = products::all();

        return response()->json(['success' => true , 'products' => $products],200);
    }

    public function store(Request $request){


        $validator = validator::make($request->all(), [

            'product_name' => 'required' ,
            'product_price' => 'required' ,
            'product_img' => 'required' ,
            'Production_Date' => 'required|date' ,
            'Expiry_date' => 'required|date|after:Production_Date' ,
            'Product_Quantity' => 'required'
        ]);



        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()]);
        }



        if($request->file('product_img')){

            $file = $request->file('product_img');
            $extension = $file->extension();

            $fileName = md5(time().now().rand(1,10)).'.'.$extension;

            $file->move(public_path('product_img'),$fileName);


        }

        $input = $request->all();
        $input['product_img'] = $fileName;


        $product = products::create($input);


        return response()->json(['success' => true , 'product' => $product],200);




    }

    public function getProductById ($id){

        $product = products::find($id);

        return response()->json(['success' => true , 'product' => $product],200);

    }

    public function update(Request $request,$id){



        $validator = validator::make($request->all(), [

            'product_name' => 'required' ,
            'product_price' => 'required' ,
            'Production_Date' => 'required|date' ,
            'Expiry_date' => 'required|date|after:Production_Date' ,
            'Product_Quantity' => 'required'
        ]);



        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()]);
        }


        $input = $request->all();


        if($request->hasFile('product_img')){

            $file = $request->file('product_img');
            $extension = $file->extension();

            $fileName = md5(time().now().rand(1,10)).'.'.$extension;

            $file->move(public_path('product_img'),$fileName);
            $input['product_img'] = $fileName;

        }else{

            $input = Arr::except($input,array('product_img'));
        }



        $product = products::find($id);
        $product->update($input);
        return response()->json(['success' => true , 'product' => $product],200);

    }

    public function destroy($id){


        $oldImg = products::where('id','=',$id)->pluck('product_img');

        $path =  public_path('product_img\\'.$oldImg[0]);

        if($oldImg[0]){
            if(file_exists($path)){

                unlink($path);
            }
        }


        $product = products::find($id);
        $product->delete();

        return response()->json(['success' => true , 'message' => 'product delete successfully'],200);
    }


}
