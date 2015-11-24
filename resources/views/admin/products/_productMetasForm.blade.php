                <div class="form-group">
                    {!! Form::label('meta_name','Meta:') !!}
                    {!! Form::text('meta_name',null,["class"=>"form-control","required"=>"true"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('meta_value','Value:') !!}
                    {!! Form::text('meta_value',null,["class"=>"form-control","required"=>"true"]) !!}
                    {!! Form::hidden('product_id',$id,["class"=>"form-control","required"=>"true"]) !!}
                </div>
				<div class="form-group">
						{!! Form::submit($submitButton,["class"=>"btn btn-primary form-control"]) !!}
				</div>