@extends('layout.main')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Add <b>a new product category meta</b></h1>
        </div>
        <div class="panel-body">
            {!! Form::model($product_category_metas = new \App\Models\Product_category_metas,["url"=>URL::ROUTE('post-product-category-meta')]) !!}
                @include('admin.product_categories._productCategoryMetasForm', ["submitButton"=>"add new product category meta"])
            {!! Form::close() !!}
        </div>
    </div>
@stop