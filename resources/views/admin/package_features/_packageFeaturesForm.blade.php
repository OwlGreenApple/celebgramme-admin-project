                <div class="form-group">
                    {!! Form::label('name','Feature:') !!}
                    {!! Form::text('feature_name',null,["class"=>"form-control","required"=>"true"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('price','Value:') !!}
                    {!! Form::text('feature_value',null,["class"=>"form-control","required"=>"true"]) !!}
                </div>
				<div class="form-group">
                    {!! Form::label('price','Package:') !!}
                    {!! Form::select('package_id',$packages,null,["class"=>"form-control","required"=>"true"]) !!}
                </div>
				<div class="form-group">
						{!! Form::submit($submitButton,["class"=>"btn btn-primary form-control"]) !!}
				</div>