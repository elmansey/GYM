<?php

namespace App\Http\Controllers\API\product_invoice;

use Illuminate\Http\Request;
use App\Models\product_invoices;
use App\Http\Controllers\Controller;
use Illuminate\support\facades\Validator;
use Carbon\Carbon;

class product_invoiceController extends Controller
{
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

         return response()->json(['success' => true, 'product_invoice' => $product_invoice],200);

   }
}
