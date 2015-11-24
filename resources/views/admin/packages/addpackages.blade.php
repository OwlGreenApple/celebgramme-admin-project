@extends('layout.main')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Add <b>a new package</b></h1>
        </div>
        <div class="panel-body">
            {!! Form::model($package = new \App\Models\Packages,["url"=>URL::ROUTE('post-package')]) !!}
                @include('admin.packages._packagesForm', ["submitButton"=>"add new package"])
            {!! Form::close() !!}
        </div>
    </div>
@stop