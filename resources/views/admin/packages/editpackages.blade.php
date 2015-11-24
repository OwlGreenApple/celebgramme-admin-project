@extends('layout.main')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Edit <b>Category</b></h1>
        </div>
        <div class="panel-body">
            {!! Form::model($package,["url"=>URL::ROUTE('update-package',$package->id),'method'=>'PATCH']) !!}
                @include('admin.packages._packagesForm', ["submitButton"=>"update package"])
            {!! Form::close() !!}
        </div>
    </div>
@stop