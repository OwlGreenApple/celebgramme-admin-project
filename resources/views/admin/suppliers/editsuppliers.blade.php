@extends('layout.main')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Add <b>a new suppliers</b></h1>
        </div>
        <div class="panel-body">
            {!! Form::model($supplier,["url"=>URL::ROUTE('update-supplier',$supplier->id),'method'=>'PATCH']) !!}
                @include('admin.suppliers._suppliersForm', ["submitButton"=>"update suppliers"])
            {!! Form::close() !!}
        </div>
    </div>
@stop