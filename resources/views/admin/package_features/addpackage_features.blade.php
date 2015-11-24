@extends('layout.main')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Add <b>a new package feature</b></h1>
        </div>
        <div class="panel-body">
            {!! Form::model($package_feature = new \Axiapro\Models\Package_features,["url"=>URL::ROUTE('post-package-feature')]) !!}
                @include('adminaxs.package_features._packageFeaturesForm', ["submitButton"=>"add new package feature"])
            {!! Form::close() !!}
        </div>
    </div>
@stop