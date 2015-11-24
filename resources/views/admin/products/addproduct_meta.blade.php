@extends('layout.main')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Add <b>a new product meta</b></h1>
        </div>
        <div class="panel-body">
            {!! Form::model($meta = new \App\Models\Product_metas,["url"=>URL::ROUTE('post-product-meta')]) !!}
                @include('admin.products._productMetasForm', ["submitButton"=>"add new product meta"])
            {!! Form::close() !!}
        </div>
    </div>
@stop