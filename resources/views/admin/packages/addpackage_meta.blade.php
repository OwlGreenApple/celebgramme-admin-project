@extends('layout.main')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Add <b>a new package meta</b></h1>
        </div>
        <div class="panel-body">
            {!! Form::model($package = new \App\Models\Package_metas,["url"=>URL::ROUTE('post-package-meta')]) !!}
                @include('admin.packages._packageMetasForm', ["submitButton"=>"add new package meta"])
            {!! Form::close() !!}
        </div>
    </div>
@stop