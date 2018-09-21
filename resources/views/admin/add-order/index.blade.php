@extends('layout.main')

@section('content')
  <div class="page-header">
    <h1>Add Order</h1>
  </div>  

  <br>

  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="text" name="from" id="from" class="form-control"> 
    </div>
    <div class="input-group fl">
      <p>hingga</p>
    </div>
    <div class="input-group fl">
      <input type="text" name="to" id="to" class="form-control"> 
    </div>  
    <div class="none"></div>
  </div>

  <div class="cover-input-group">
    <div class="input-group fl">
      <select name="select_group" id="select_group" class="form-control">
        <option>Daily</option>
        <!--<option>Weekly</option>-->
        <option>Monthly</option>
      </select>
    </div>
  </div>

  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="button" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
    <div class="none"></div>
  </div>

  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
  
  <div id="chartContainer" style="height: 370px; width: 100%;"></div>

  <script>
    function refresh_page()
    {
      $.ajax({                                      
        url: '<?php echo url('order-chart/load-chart'); ?>',
        type: 'get',
        data: {
          from: $("#from").val(),
          to: $("#to").val(),
          select_group:$("#select_group").val(),
        },
        beforeSend: function()
        {
          $("#div-loading").show();
        },
        dataType: 'json',
        success: function(data)
        {
          $("#div-loading").hide();
        }
      });
    }

    $(document).ready(function(){
      $("#alert").hide();
      refresh_page();
      
      $("#from").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
      });
      $("#from").datepicker('setDate', new Date());

      $("#to").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
      });
      $("#to").datepicker('setDate', new Date());

      $('#button-search').click(function(e){
        e.preventDefault();
        refresh_page();
      });
      
    });
  </script>   
  
@endsection