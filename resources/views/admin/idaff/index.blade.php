@extends('layout.main')

@section('content')
  <div class="page-header">
    <h1>Idaff</h1>
  </div>  

  <div>
    <form>
      <div class="col-md-12 form-group row">
        <label for="invoice" class="col-md-2 col-form-label text-md-left">
          Invoice
        </label>

        <div class="col-md-2 col-12">
          <input type="text" class="form-control" name="invoice" id="invoice">
        </div>
      </div>

      <div class="col-md-12 form-group row">
        <label for="transid" class="col-md-2 col-form-label text-md-left">
          Trans ID
        </label>
        <div class="col-md-2 col-12">
          <input type="text" class="form-control" name="transid" id="transid">
        </div>
      </div>

      <div class="col-md-12 form-group row">
        <label for="cname" class="col-md-2 col-form-label text-md-left">
          Cname
        </label>
        <div class="col-md-2 col-12">
          <input type="text" class="form-control" name="cname" id="cname">
        </div>
      </div>

      <div class="col-md-12 form-group row">
        <label for="cemail" class="col-md-2 col-form-label text-md-left">
          Cemail
        </label>
        <div class="col-md-2 col-12">
          <input type="text" class="form-control" name="cemail" id="cemail">
        </div>
      </div>

      <div class="col-md-12 form-group row">
        <label for="cmphone" class="col-md-2 col-form-label text-md-left">
          Cmphone
        </label>
        <div class="col-md-2 col-12">
          <input type="text" class="form-control" name="cmphone" id="cmphone">
        </div>
      </div>

      <div class="col-md-12 form-group row">
        <label for="status" class="col-md-2 col-form-label text-md-left">
          Status
        </label>
        <div class="col-md-2 col-12">
          <input type="text" class="form-control" name="status" id="status">
        </div>
      </div>

      <div class="col-md-12 form-group row">
        <label for="grand_total" class="col-md-2 col-form-label text-md-left">
          Grand Total
        </label>
        <div class="col-md-2 col-12">
          <input type="text" class="form-control" name="grand_total" id="grand_total">
        </div>
      </div>
    </form>

    <div class="cover-input-group">
      <div class="input-group fl">
        <input type="button" value="Submit" id="button-submit" data-loading-text="Loading..." class="btn btn-primary"> 
      </div>
    </div>
  </div>
  
  <div class="alert alert-danger" id="alert" style="display: none">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  

  <script>
    $(document).ready(function(){
      $("#alert").hide();
      
      $('#button-submit').click(function(e){
        e.preventDefault();
        $.ajax({
          url: '<?php echo url('idaff/post-back'); ?>',
          type: 'get',
          data: $('form').serialize(),
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            var data = jQuery.parseJSON(result);
            console.log('success');
            $("#alert").show();
            $("#alert").html(data.message);
            if(data.status=='success') {
              $("#alert").addClass("alert-success");
              $("#alert").removeClass("alert-danger");
            } else {
              $("#alert").addClass("alert-danger");
              $("#alert").removeClass("alert-success");
            }
            $("#div-loading").hide();
          }
        });
      });


    });
  </script>   
  
@endsection
