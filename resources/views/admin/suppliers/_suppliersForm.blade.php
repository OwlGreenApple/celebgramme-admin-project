                <div class="form-group">
                    {!! Form::label('supplier','Supplier Name:') !!} 
                    {!! Form::text('supplier_company_name',null,["class"=>"form-control","required"=>"true"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('address','Supplier Address:') !!} 
                    {!! Form::text('supplier_address',null,["class"=>"form-control","required"=>"true"]) !!}
                </div>
				<div class="form-group">
                    {!! Form::label('supplier_phone','Supplier Phone:') !!} 
                    {!! Form::text('supplier_phone',null,["class"=>"form-control","required"=>"true"]) !!}
                </div>
				<div class="form-group">
						{!! Form::submit($submitButton,["class"=>"btn btn-primary form-control"]) !!}
				</div>