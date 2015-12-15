@extends('layout.main')

@section('content')
  <div class="page-header">
    <h1>Invoice</h1>
  </div>  
  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="text" id="from" class="form-control"> 
    </div>
    <div class="input-group fl">
      <p>hingga</p>
    </div>
    <div class="input-group fl">
      <input type="text" id="to" class="form-control"> 
    </div>  
    <div class="none"></div>
  </div>
  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="button" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>
  </div>
  
  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
  <table class="table table-bordered">  
    <thead>
      <tr>
        <th>No. Invoice</th>
        <th>Total</th>
        <th>Nama</th>
      </tr>      
    </thead>
    
    
    <tbody id="content">
    </tbody>
    
  </table>  
  
  <nav>
    <ul class="pagination" id="pagination">
    </ul>
  </nav>  
  
  <div id="div-confirm">
  </div>
  
  <script>
      
    $(function() {
      $("#from").datepicker({
        dateFormat: 'dd-mm-yy',
        showWeek: true,
        changeMonth: true,
        changeYear: true,        
        onSelect: function(d) {
          var from = $('#from').datepicker('getDate');
          var to = $('#to').datepicker('getDate');
          if (from.getTime() > to.getTime()){
            $("#from").datepicker('setDate', to);
          }
        }
      });
      $("#to").datepicker({
        dateFormat: 'dd-mm-yy',
        showWeek: true,
        changeMonth: true,
        changeYear: true,        
        onSelect: function(d) {
          var from = $('#store_order_list_fromdate').datepicker('getDate');
          var to = $('#store_order_list_todate').datepicker('getDate');
          if (from.getTime() > to.getTime()){
            $("#to").datepicker('setDate', from);
          }
        }
      });
      var d = new Date();
      d.setDate(1);
      d.setMonth(-1);
      $("#from").datepicker('setDate', d);
      $("#to").datepicker('setDate', new Date());
    });
    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-invoice'); ?>',
        type: 'get',
        data: {
          page: page,
          from: ($('#from').datepicker('getDate').getTime()/1000+(3600*24+1)),
          to: ($('#to').datepicker('getDate').getTime()/1000+(3600*24+1)),
        },
        beforeSend: function()
        {
          $("#div-loading").show();
        },
        dataType: 'text',
        success: function(result)
        {
          $('#content').html(result);
          $("#div-loading").hide();
        }
      });
    }
    function create_pagination()
    {
      $.ajax({
        url: '<?php echo url('pagination-invoice'); ?>',
        type: 'get',
        data: {
          from: ($('#from').datepicker('getDate').getTime()/1000+(3600*24+1)),
          to: ($('#to').datepicker('getDate').getTime()/1000+(3600*24+1)),
        },
        beforeSend: function()
        {
          $("#div-loading").show();
        },
        dataType: 'text',
        success: function(result)
        {
          $('#pagination').html(result);
          
          $('#pagination a').click(function(e){
            e.preventDefault();
            $('#pagination a').removeClass('active');
            $('#pagination a[data-pageid='+$(this).attr('href')+']').addClass('active');
            refresh_page($(this).attr('href'));
          });
          
          // $("#div-loading").hide();
        }
      });
    }
    $(document).ready(function(){
      $("#alert").hide();
      refresh_page(1);
      create_pagination();
      $('#button-search').click(function(e){
        e.preventDefault();
        create_pagination();
        refresh_page(1);
      });


    });
  </script>		
  
@endsection
