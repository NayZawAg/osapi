<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Item;
use App\Http\Resources\ItemResource;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items=Item::all();
        return ItemResource::collection($items);
    }

    public function __construct($value='')
    {
        // $this->middleware('auth:api');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd

        //validation
         $request->validate([
            'item_codeno'=>'required|min:4',
            'item_name'=>'required',
            'item_photo'=>'required',
            'unit_price'=>'required',
            'discount_price'=>'required',
            'brand_id'=>'required',
            'subcategory_id'=>'required',
            'item_des'=>'required',
        ]);

        //if include file, upload
         $imageName=time().'.'.$request->item_photo->extension();
            
        $request->item_photo->move(public_path('backend/itemimg'),$imageName);
        $myfile='backend/itemimg/'.$imageName;
        //data request
        $item=new Item; //setup class
        $item->codeno=$request->item_codeno;
        $item->name=$request->item_name;
        $item->photo=$myfile;
        $item->price=$request->unit_price;
        $item->discount=$request->discount_price;
        $item->description=$request->item_des;
        $item->brand_id=$request->brand_id;
        $item->subcategory_id=$request->subcategory_id;
        $item->save();

        //redirect
        return new ItemResource($item);
    }   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item=Item::findOrFail($id);
        return new ItemResource($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
