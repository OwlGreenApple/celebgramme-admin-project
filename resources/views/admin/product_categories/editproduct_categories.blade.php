@extends('layout.main')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Edit <b>Category</b></h1>
        </div>
        <div class="panel-body">
		
            {!! Form::model($category,["files"=>"true", "url"=>URL::ROUTE('update-product-category',$category->category_slug),'method'=>'PATCH']) !!}
                @include('admin.product_categories._productCategoriesForm', ["submitButton"=>"update category"])
            {!! Form::close() !!}
        </div>
    </div>
@stop