@extends('layout.main')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Edit <b>Product</b></h1>
        </div>
        <div class="panel-body">
            {!! Form::model($product,["url"=>URL::ROUTE('update-product',$product->product_slug),'method'=>'PATCH','files'=>'true']) !!}
                @include('admin.products._productsForm', ["submitButton"=>"update product"])
            {!! Form::close() !!}
		</div>
    </div>
@stop