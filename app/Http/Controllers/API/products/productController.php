<?php

namespace App\Http\Controllers\API\products;

use Carbon\Carbon;
use App\Models\products;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\helperMe\addActivetyLogInHistory;
use Illuminate\Support\Facades\Validator;

class productController extends Controller
{

    use addActivetyLogInHistory;


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

            $file->move('product_img/',$fileName);


        }

        $input = $request->all();
        $input['product_img'] = $fileName;


        $product = products::create($input);

        // save logs
        $userId = auth()->user()->id;
        $title  = 'has added a new product in store  ' . $product['product_name'];
        $date = Carbon::now('Africa/Cairo')->format('D, M, d Y H:i:s A');
        $this->saveLogs($userId,$title,$date);



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

            $file->move('product_img/',$fileName);
            $input['product_img'] = $fileName;

        }else{

            $input = Arr::except($input,array('product_img'));
        }



        $product = products::find($id);
        $product->update($input);



        $userId = auth()->user()->id;
        $title  = 'has update in  product  ' . $product['product_name'];
        $date = Carbon::now('Africa/Cairo')->format('D, M, d Y H:i:s A');
        $this->saveLogs($userId,$title,$date);

        return response()->json(['success' => true , 'product' => $product],200);

    }

    public function destroy($id){


        $oldImg = products::where('id','=',$id)->pluck('product_img');

        $path =  'product_img\\'.$oldImg[0];

        if($oldImg[0]){
            if(file_exists($path)){

                unlink($path);
            }
        }


        $product = products::find($id);
        $product->delete();


        $userId = auth()->user()->id;
        $title  = 'has delete  a  product  ' . $product['product_name'] . '  from store ';
        $date = Carbon::now('Africa/Cairo')->format('D, M, d Y H:i:s A');
        $this->saveLogs($userId,$title,$date);

        return response()->json(['success' => true , 'message' => 'product delete successfully'],200);
    }


}
