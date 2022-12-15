<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Carbon\Carbon;
use GuzzleHttp\Psr7\PumpStream;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;
use PHPUnit\Util\Filter;
class ProductController extends Controller
{
    protected $product, $products, $ProductVariantPrice, $variants, $last_id, $lid, $tdate, $dat, $title;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */


    public function index(Request $request)
    {
       //filter
       $tdate = Carbon::now()->format('d/m/y');
      $this->products = Product::when($request->date != null, function ($q) use ($request){
        return $q->whereDate('created_at',$request->date);
       }, function($q) use ($tdate){
        return $q->whereDate('created_at',$tdate);
       })->paginate(2);

        $this->variants =Variant::all('title');

        //for pagination
        $this->products = Product::paginate(2);

        return view('products.index', [
            'products' => $this->products,
            'variants' => $this->variants,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $this->products = Product::all();
        $variants = Variant::all();
//        return view('products.create', compact('variants'));
        return view('products.create',[
            'products' => $this->products,
            'variants' => $this->variants,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
       Product::createOrUpdateProduct($request);
//         ProductImage::createOrUpdateProductImage($request);
//       return $request->all();
//       return Product::createProduct($request);
        return redirect()->back()->with('success', 'Product Created Successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
        $product=Product::findOrFail($product);
        return view('products.index')->with('product',$product);
        dd($product);  // This will never be executed.
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
       $this->product = Product::find($product);
        return view('products.edit', compact('variants', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product = Product::findOrFail($product);
        $product->fill($request->all());
        $product->save();
        return redirect()->back()->with('success', 'Variant Updated');
//        Product::createOrUpdateProduct($request, $product);
//        return redirect()->back()->with('success', 'Product Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
