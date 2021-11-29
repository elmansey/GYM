<?php

namespace App\Http\Controllers\API\product_invoice;

use Illuminate\Http\Request;
use App\Models\product_invoices;
use App\Http\Controllers\Controller;
use Illuminate\support\facades\Validator;
use Carbon\Carbon;
use App\Http\helperMe\addActivetyLogInHistory;

class product_invoiceController extends Controller
{

    use addActivetyLogInHistory;

   public function store(Request $request){


        $validator = validator::make($request->all(), [
            'invoice_number' => 'required',
            'seller' => 'required',
            'invoice_details' => 'required',
            'invoice_total' => 'required'
        ]);

        $details = json_decode($request['invoice_details'],true);

        $input = $request->all();

        $input['invoice_details'] = $details;
        $input['date'] = Carbon::now()->toDateString();
        $input['time'] = Carbon::now()->toTimeString();



         $product_invoice = product_invoices::create($input);


          //save logs
        $userId = auth()->user()->id;
        $title  = 'has Sell New Products , Invoice Number  is  ' . $product_invoice['invoice_number'];
        $date = Carbon::now('Africa/Cairo')->format('D, M, d Y H:i:s A');
        $this->saveLogs($userId,$title,$date);

         return response()->json(['success' => true, 'product_invoice' => $product_invoice],200);

   }
}
