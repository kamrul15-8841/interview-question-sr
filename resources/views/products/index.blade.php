@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>


    <div class="card">
        <form action="" method="get" class="card-header">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" placeholder="Product Title" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="variant" id="" class="form-control">
                        <option value="" selected disabled><-- Select a Variant--></option>
                        @foreach($variants as $key=>$variant)
                            <option>{{$variant->title}}</option>

                            @foreach($products as $key=>$product)
                                <option>{{$product->productVariant->variant}}</option>
                            @endforeach

                        @endforeach

                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="text" name="price_from" aria-label="First name" placeholder="From" class="form-control">
                        <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date" placeholder="Date" value="{{ 'd/m/y' }}" class="form-control">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <div class="table-response">
                <table class="table display" id="basic-datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Variant</th>
                        <th width="150px">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{$loop->iteration}}</td>
{{--                        <td>{{$product->title}}<br> Created at :  {!! date('$product->created_at') !!}</td>--}}
                        <td>{{$product->title}}<br> Created at :  {{ $product->created_at->format('D-M-Y')}}</td>
                        <td>{!! \Illuminate\Support\Str::words($product->description, 5,'...') !!}</td>
                        <td>
                            <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">

                                <dt class="col-sm-3 pb-0">
                                    {{$product->productVariant->variant}}/{{$product->productVariant->variant}}/{{$product->productVariant->variant}}
                                </dt>
                                <dd class="col-sm-9">
                                    <dl class="row mb-0">
{{--                                        <dt class="col-sm-4 pb-0">Price : {{$product->productPrice->price}}</dt>--}}
                                        <dt class="col-sm-4 pb-0">Price : {{ number_format($product->ProductVariantPrice->price,1)}}</dt>
{{--                                        <dd class="col-sm-8 pb-0">InStock : {{ number_format(50,0) }}</dd>--}}
                                        <dd class="col-sm-8 pb-0">InStock : {{ number_format($product->ProductVariantPrice->stock,0) }}.</dd>
                                    </dl>
                                </dd>
                            </dl>
                            <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('product.edit', ['product' => $product->id]) }}" class="btn btn-success">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>

                </table>

                <div class="col-md-6 mx-auto">
                   <div class="btn-group">
                       <h3 class="text-center">{{$products->links()}}</h3>
                   </div>
                </div>
            </div>

        </div>

        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-md-6">
{{--                    <p>Showing 1 of {{$products->find('id',2)}} out of {{$products->first()->find('id')}}</p>--}}
{{--                    <p>Showing 1 to {{$products->find('id',2)}} out of {{$lid}}</p>--}}
                    <p>Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} out of {{ $products->total() }}</p>

                </div>
                <div class="col-md-2">

                </div>
            </div>
        </div>
    </div>

@endsection
