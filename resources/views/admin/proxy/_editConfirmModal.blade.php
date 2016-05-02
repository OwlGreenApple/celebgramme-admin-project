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
        <h4 class="modal-title">Edit Konfirmasi: </h4>
      </div>
      <div class="modal-body">
        <div class="row-fluid">
          <form class="form-horizontal" id="form-confirm">
            <input type="hidden" value="{{$tb_konfirmasi_premi->id}}" name="idConfirm">
                <div class="form-group">
                  <label for="noHP" class="col-sm-2 control-label">No HP</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="noHP" name="noHP" value="{{$tb_konfirmasi_premi->nohp}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="email" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="email" name="email" value="{{$tb_konfirmasi_premi->email}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="jenisPremi" class="col-sm-2 control-label">Jenis Premi</label>
                  <div class="col-sm-5">
                    <select class="form-control" id="jenisPremi" name="jenisPremi">
                    <?php foreach ($config_packages as $config) {?>
                      <option value="{{$config->id}}" <?php if ($tb_konfirmasi_premi->config_package_id==$config->id) echo "selected"; ?>>{{$config->name." - Rp. ".number_format($config->value,0,'','.')}}</option>
                    <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="topup" class="col-sm-2 control-label">Top up</label>
                  <div class="col-sm-5">
                    <select class="form-control" id="topup" name="topup">
                      <option <?php if ($tb_konfirmasi_premi->topup==3000000) echo "selected"; ?> value="3000000">Rp 3.000.000,-</option>
                      <option <?php if ($tb_konfirmasi_premi->topup==6000000) echo "selected"; ?> value="6000000">Rp 6.000.000,-</option>
                      <option <?php if ($tb_konfirmasi_premi->topup==9000000) echo "selected"; ?> value="9000000">Rp 9.000.000,-</option>
                      <option <?php if ($tb_konfirmasi_premi->topup==12000000) echo "selected"; ?> value="12000000">Rp 12.000.000,-</option>
                      <option <?php if ($tb_konfirmasi_premi->topup==24000000) echo "selected"; ?> value="24000000">Rp 24.000.000,-</option>
                      <option <?php if ($tb_konfirmasi_premi->topup==36000000) echo "selected"; ?> value="36000000">Rp 36.000.000,-</option>
                      <option <?php if ($tb_konfirmasi_premi->topup==48000000) echo "selected"; ?> value="48000000">Rp 48.000.000,-</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" id="save-confirm">Save</button>
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
