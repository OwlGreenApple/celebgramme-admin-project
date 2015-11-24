                <div class="form-group">
                    {!! Form::label('name','Package:') !!}
                    {!! Form::text('package_name',null,["class"=>"form-control","required"=>"true"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('price','Price:') !!}
                    {!! Form::text('package_price',null,["class"=>"form-control","required"=>"true"]) !!}
                </div>
				<div class="form-group">
						{!! Form::submit($submitButton,["class"=>"btn btn-primary form-control"]) !!}
				</div>