<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transactions;
use App\Item;

class TransactionsController extends Controller
{
    public function create()
    {
    	$item = Item::all();
    	return view('transactions.create', ['item' => $item]);
    }
 
    public function store(Request $request)
    {
    	$this->validate($request,[
    		'customer_name' => 'required',
    		'item_id' => 'required'
    	]);
 
        Transactions::create([
    		'customer_name' => $request->customer_name,
    		'item_id' => $request->item_id
    	]);
 
    	return redirect('/pendaftaran');
    }
}