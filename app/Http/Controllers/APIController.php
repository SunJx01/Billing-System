<?php
namespace App\Http\Controllers;

use App\Models\bill;
use App\Models\products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function billing()
    {   
        $data = products::get();
        foreach ($data as $key => $item) {
            $data[$key]['quantity'] = 1;
        }
        return view('invoice', compact('data'));
    }
    public function product()
    {
        $data = products::get();
        return view('products',compact('data'));
    }
    public function prodAdd(Request $request){
            $arr = [
                'name' => $request->params['name'],
                'price' => $request->params['price'],
                'stock' => $request->params['stock'],
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ];
            $product = products::create($arr);
            return response()->json(['success' => true, 'product' => $product], 201);
    }
    public function updStock(Request $request){
        $newStock = $request->newStock;
        $productDet = $request->productDet;
        $id = $productDet['id'];
        $oldStock = $productDet['stock'];

        $product = products::where('id', $id)-> first();
        
        $product->stock = $oldStock + $newStock;
        $product->updated_at = date('Y-m-d h:i:s');
        $product->save();
        return response()->json(['success' => true, 'product' => $product], 201);
    }
   
    public function genInvoice(Request $request){

        $cart = $request->cart;
        $total = $request->subtotal;
        $discountPer = $request->discount;
        $taxPer = $request->taxRate;
        $discount = ($discountPer / 100) * $total;
        $tax = $taxPer * ($total - $discount);
        $payment = $request->paymentMethod;
        $contact = $request->customerContact;
        $rand = Str::random(9);

        $invoiceContent = "Invoice\n";
        $invoiceContent .= "Contact:".$contact."\n";
        $invoiceContent .= "\n----------------------------------------\n";
        $invoiceContent .= "Bill Number:" .$rand. "\n";
        $invoiceContent .= "Payment Method: " . $payment . "\n\n";
        $invoiceContent .= "Items Purchased:\n";
        $invoiceContent .= "\n----------------------------------------\n";

        foreach ($cart as $item) {
            $invoiceContent .= "- " . $item['name'] . " x " . $item['quantity'] . " @ NRs." . $item['price'] . "\n";
        }
        $invoiceContent .= "\n----------------------------------------\n";
        $invoiceContent .= "\n----------------------------------------\n";
        $invoiceContent .= "Subtotal: NRs." . number_format($total, 2) . "\n";
        $invoiceContent .= "Discount: NRs." . number_format($discount, 2) . "\n";
        $invoiceContent .= "Tax: NRs." . number_format($tax, 2) . "\n";
        $invoiceContent .= "Total: NRs." . number_format(($total - $discount) + $tax, 2) . "\n";
        $invoiceContent .= "\n----------------------------------------\n";
        $invoiceContent .= "\nThank you for your purchase!\n";

        $filename = 'bill_' . $rand . '.txt';
        Storage::disk('public')->put($filename, $invoiceContent);

        $arr = [
            'bill_number' => $filename,
            'contact' => $contact,
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $product = bill::create($arr);
        
        foreach($cart as $item){
            $stockUpdate = products::where('name', $item['name'])->first();
            $newStock = $stockUpdate->stock - $item['quantity'];
            $stockUpdate->update([
                'stock' => $newStock
            ]);
        }
        return response()->json(['success' => true, 'product' => $product, 'bill' => $filename], 201);
    }
    public function printInvoice($bill) {
        $filename = $bill;
        return view('print_invoice', compact('filename'));
    }

}
