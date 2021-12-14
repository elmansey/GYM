<?php

namespace App\Http\Controllers\API\product_invoice;

use Illuminate\Http\Request;
use App\Models\product_invoices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Http\helperMe\addActivetyLogInHistory;

class product_invoiceController extends Controller
{

    use addActivetyLogInHistory;



    public function index()
    {


        $product_invoices = product_invoices::with('sellerRelation')->get();

        return response()->json(['success' => true, 'product_invoices' => $product_invoices]);
    }


    public function product_invoicesOnlyArchived()
    {


        $product_invoices_archived = product_invoices::with('sellerRelation')->onlyTrashed()->get();

        return response()->json(['success' => true, 'product_invoices_archived' => $product_invoices_archived]);
    }

    public function store(Request $request)
    {


        $validator = validator::make($request->all(), [
            'invoice_number' => 'required',
            'seller' => 'required',
            'invoice_details' => 'required',
            'invoice_total' => 'required'
        ]);




        if ($validator->fails()) {

            return response()->json(['success' => false, 'message' => $validator->errors()], 200);
        }

        $details = json_decode($request['invoice_details'], true);

        $input = $request->all();

        $input['invoice_details'] = $details;
        $input['date'] = Carbon::now()->toDateString();
        $input['time'] = Carbon::now()->toTimeString();



        $product_invoice = product_invoices::create($input);


        //save logs
        $userId = auth()->user()->id;
        $title  = 'has Sell New Products , Invoice Number  is  ' . $product_invoice['invoice_number'];
        $date = Carbon::now('Africa/Cairo')->format('D, M, d Y H:i:s A');
        $this->saveLogs($userId, $title, $date);

        return response()->json(['success' => true, 'product_invoice' => $product_invoice], 200);
    }


    public function getInvoiceById($id)
    {


        $invoice  = product_invoices::with('sellerRelation')->where('id', '=', $id)->first();


        if ($invoice == null) {

            $invoice  = product_invoices::with('sellerRelation')->where('id', '=', $id)->withTrashed()->first();
        }

        return response()->json(['success' => true, 'invoice' => $invoice]);
    }


    public function destroy($id)
    {

        $invoice = product_invoices::find($id);

        if ($invoice == null) {

            $invoice = product_invoices::withTrashed()->find($id);
        }


        $invoice->forceDelete();


        //save logs
        $userId = auth()->user()->id;
        $title  = 'has delete  Products invoice  , Invoice Number  is  ' . $invoice['invoice_number'];
        $date = Carbon::now('Africa/Cairo')->format('D, M, d Y H:i:s A');
        $this->saveLogs($userId, $title, $date);

        return response()->json(['success' => true, 'message' => 'invoice delete successfully']);
    }


    public function archivedThisInvoice($id)
    {


        $invoice = product_invoices::find($id);

        $invoice->delete();


        //save logs
        $userId = auth()->user()->id;
        $title  = 'has archived  Products invoice  , Invoice Number  is  ' . $invoice['invoice_number'];
        $date = Carbon::now('Africa/Cairo')->format('D, M, d Y H:i:s A');
        $this->saveLogs($userId, $title, $date);


        return response()->json(['success' => true, 'message' => 'invoice archived successfully']);
    }


    public function restoreInvoiceInvoice($id)
    {

        $invoice = product_invoices::withTrashed()->find($id);
        $invoice->restore();


        //save logs
        $userId = auth()->user()->id;
        $title  = 'has restored form archive  Products invoice  , Invoice Number  is  ' . $invoice['invoice_number'];
        $date = Carbon::now('Africa/Cairo')->format('D, M, d Y H:i:s A');
        $this->saveLogs($userId, $title, $date);

        return response()->json(['success' => true, 'message' => 'invoice restored successfully']);
    }
}
