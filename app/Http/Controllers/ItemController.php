<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ItemController extends Controller
{
    public function index()
    {
    	$item = Item::all();
    	return view('item.index', ['item' => $item]);
    }

    public function create()
    {
    	return view('item.create');
    }
 
    public function store(Request $request)
    {
    	$this->validate($request,[
    		'name' => 'required',
    	]);
 
        Item::create([
    		'name' => $request->name,
    	]);
 
    	return redirect('/item');
    }
    
    public function edit($id)
    {
        $item = Item::find($id);
        return view('item.edit', ['item' => $item]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request,[
           'name' => 'required'
        ]);
     
        $item = Item::find($id);
        $item->name = $request->name;
        $item->save();
        return redirect('/item');
    }

    public function delete($id)
    {
        $item = Item::find($id);
        $item->delete();
        return redirect('/item');
    }
}
