@extends('layout.main')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Add <b>a new suppliers</b></h1>
        </div>
        <div class="panel-body">
            {!! Form::model($suppliers = new \App\Models\Suppliers,["url"=>URL::ROUTE('post-suppliers')]) !!}
                @include('admin.suppliers._suppliersForm', ["submitButton"=>"add new suppliers"])
            {!! Form::close() !!}
        </div>
    </div>
@stop