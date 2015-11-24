@extends('layout.main')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Edit <b>Package Feature</b></h1>
        </div>
        <div class="panel-body">
            {!! Form::model($package_feature,["url"=>URL::ROUTE('update-package-feature',$package_feature->id),'method'=>'PATCH']) !!}
                @include('adminaxs.package_features._packageFeaturesForm', ["submitButton"=>"update package feature"])
            {!! Form::close() !!}
        </div>
    </div>
@stop