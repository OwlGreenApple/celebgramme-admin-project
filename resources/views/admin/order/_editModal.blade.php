<style>
    .column {
      float: left;
      margin-right: 50px;
    }
    
    body .modal-dialog{
        /* new custom width */
        width: 150%px;
    }
</style>
<div class="modal fade  bs-example-modal-lg" id="edit-show">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Data Shipping Order: </h4>
      </div>
      <div class="modal-body">
        <div class="row-fluid">
          <form class="form-horizontal" id="form-edit">
            <input type="hidden" name="orderId" value="{{$data->id}}">
              <div class="form-group">
                <label for="noShipping" class="col-sm-2 control-label">Shipping number</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="noShipping" name="noShipping" value="{{$data->shipping_number}}">
                </div>
              </div>
              <div class="form-group">
                <label for="shippingStatus" class="col-sm-2 control-label">Shipping status</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="shippingStatus" name="shippingStatus" value="{{$data->order_shipping_status}}">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-default" id="save-update">Save</button>
                </div>
              </div>
          </form>
        </div>
        
      </div>
      <div class="modal-footer">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

  <script>
    $(document).ready(function(){
      $("#alert").hide();
      $( "#save-update" ).click(function(e) {
        e.preventDefault();
					var uf = $('#form-edit');
					var fd = new FormData(uf[0]);
					$.ajax({
						headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						url: "update-order",
						type: "post",
						data : fd,
						processData:false,
						contentType: false,
						dataType: "text",
            beforeSend: function()
            {
              $("#div-loading").show();
            },
						success: function(result){	
							var data = jQuery.parseJSON(result);
              $("#alert").show();
              $("#alert").html(data.message);
							if(data.type=='success')
							{
                $("#alert").addClass('alert-success');
                $("#alert").removeClass('alert-danger');
                
                $("#edit-show").modal("toggle");
                $("#tr-"+data.id).find(".shipping_no").html($("#noShipping").val());
                $("#tr-"+data.id).find(".shipping_status").html($("#shippingStatus").val());
							}
							else if(data.type=='error')
							{
                $("#alert").addClass('alert-danger');
                $("#alert").removeClass('alert-success');
							}
              $("#div-loading").hide();
              $( "body" ).scrollTop( 0 );
						}
					});
      });
    });
  </script>		
