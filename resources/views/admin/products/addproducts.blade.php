@extends('layout.main')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Add <b>a new product</b></h1>
        </div>
        <div class="panel-body">
            {!! Form::model($products = new \App\Models\Products,["url"=>URL::ROUTE('post-product'),"files"=>"true"]) !!}
                @include('admin.products._productsForm', ["submitButton"=>"add new product"])
            {!! Form::close() !!}
        </div>
		<ul>
    @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</ul>
    </div>
@stop