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
<div class="modal fade  bs-example-modal-lg" id="confirm-edit">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Daftar Order: </h4>
      </div>
      <div class="modal-body">
        <div class="row-fluid">
          <table class="table table-bordered">  
            <thead>
              <tr>
                <th>No Order</th>
                <th>Nama Customer</th>
                <th>Subtotal</th>
                <th>Biaya Pengiriman</th>
                <th>Total</th>
                <th>Metode Pembayaran</th>
                <th>Status Pembayaran</th>
                <th>Status Pengiriman</th>
                <th>Created</th>
              </tr>      
            </thead>
            
            
            <tbody id="">
              <?php foreach ($orders as $order) { ?>
              <tr>
                <td>{{$order->no_order}}</td>
                <td>{{$order->customer_id}}</td>
                <td>{{$order->order_subtotal}}</td>
                <td>{{$order->order_shipment_fee}}</td>
                <td>{{$order->order_total}}</td>
                <td>{{$order->payment_method}}</td>
                <td>{{$order->order_payment_status}}</td>
                <td>{{$order->order_shipping_status}}</td>
                <td>{{$order->created_at}}</td>
              </tr>
              <?php } ?>
            </tbody>
            
          </table>  
          
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
      $( "#save-confirm" ).click(function(e) {
        e.preventDefault();
					var uf = $('#form-confirm');
					var fd = new FormData(uf[0]);
					$.ajax({
						headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						url: "update-confirm",
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
                
                $("#confirm-edit").modal("toggle");
                $("#tr-"+data.id).find(".data-nohp").html($("#noHP").val());
                $("#tr-"+data.id).find(".data-email").html($("#email").val());
                $("#tr-"+data.id).find(".data-jumlah").html(data.jumlah);
                $("#tr-"+data.id).find(".data-topup").html(data.topup);
                $("#tr-"+data.id).find(".data-total").html(data.total);
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
