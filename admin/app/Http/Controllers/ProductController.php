<?php

namespace App\Http\Controllers;

use App\Jobs\ProductCreated;
use App\Jobs\ProductDeleted;
use App\Jobs\ProductUpdated;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    //
    public function index()
    {
        return Product::all() ;
    }

    public function show($id)
    {
        return Product::find($id);
    }

    /*
    here we used Response from Symfony\Component\HttpFoundation\Response   to can write 201  as  Response::HTTP_CREATED
    */

    public function store(Request $request, )
    {
        $product = Product::create($request->only(['title','image']));

        // here we will fire this job / event to ba catched on main app
        // and here we should send data as array not object
        ProductCreated::dispatch($product->toArray())->onQueue('main_queue') ;

        return response($product, Response::HTTP_CREATED) ;   // 201
    }


    public function update($id,Request $request )
    {
        $product = Product::findOrFail($id) ;
        $product->update($request->only(['title','image']));
        ProductUpdated::dispatch($product->toArray())->onQueue('main_queue') ;
        return response($product, Response::HTTP_ACCEPTED) ;  //  202

    }

    public function destroy($id)
    {
           Product::destroy($id) ;
           ProductDeleted::dispatch($id)->onQueue('main_queue') ; ;
            return response( null, Response::HTTP_NO_CONTENT) ;  // 204

    }




}
