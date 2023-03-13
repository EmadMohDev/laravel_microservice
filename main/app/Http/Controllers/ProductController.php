<?php

namespace App\Http\Controllers;

use App\Jobs\ProductLiked;
use App\Models\Product;
use App\Models\ProductUser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends Controller
{
    //
    public function index()
    {
        return Product::all() ;
    }

    public function like($id, Request $request)
    {
        /*
          - As of Docker version 18.03, you can use the host.docker.internal hostname
          to connect to your Docker host from inside a Docker container.
         link :  https://medium.com/@TimvanBaarsen/how-to-connect-to-the-docker-host-from-inside-a-docker-container-112b4c71bc66
       */
        $user =  \Http::post("http://host.docker.internal:8000/api/user") ;

        try {
           $productUser =  ProductUser::create([
                'product_id' => $id ,
                'user_id' => $user['id']
            ]);

            ProductLiked::dispatch($productUser->toArray())->onQueue('admin_queue');
            return response(['message'=>'Success'], Response::HTTP_OK) ;

       }catch (\Exception $e){

            return response(['error'=>'You already liked this product'], Response::HTTP_BAD_REQUEST) ;

        }

    }



}
