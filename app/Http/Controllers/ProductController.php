<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return 'Index Method!';
        return view('products');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) 
    {
        $product= new Product();    //add product
        $product->name= $request->has('name')? $request->get('name'):'';
        $product->price= $request->has('price')? $request->get('price'):'';
        $product->amount= $request->has('amount')? $request->get('amount'):'';
        $product->is_active= 1;

        if($request->hasFile('images')){
            $files = $request->file('images');

            $imageLocation= array();
            $i=0;
            foreach ($files as $file){
                $extension = $file->getClientOriginalExtension();
                $fileName= 'product_'. time() . ++$i . '.' . $extension;
                $location= '/images/uploads/';  //location of image
                $file->move(public_path() . $location, $fileName);  //move to location
                $imageLocation[]= $location. $fileName;
            }

            $product->image= implode('|', $imageLocation);
            $product->save();
            return back()->with('success', 'Product Successfully Saved!');
        } else{
            return back()->with('error', 'Product was not saved Successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function addProduct(){
        $products= Product::all();
        $returnProducts= array();

        foreach ($products as $product){
            $images= explode('|', $product->image);

            $returnProducts[] = [
               'name'=> $product->name, //store name in returnProduct name
               'price'=> $product->price,
               'amount'=> $product->amount,
               'image'=> $images[0] //store image
            ];

        }

        return view('add_product', compact('returnProducts')); //pass return product array to view
    }
}