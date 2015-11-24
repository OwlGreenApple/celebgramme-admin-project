@extends('layout.main')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Add <b>a new category</b></h1>
        </div>
        <div class="panel-body">
            {!! Form::model($category = new \App\Models\Product_categories,["url"=>URL::ROUTE('post-product-category'),"files"=>"true"]) !!}
                @include('admin.product_categories._productCategoriesForm', ["submitButton"=>"add new category"])
            {!! Form::close() !!}
        </div>
    </div>
@stop