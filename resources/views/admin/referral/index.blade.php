@extends('layout.main')

@section('content')
  <script type="text/javascript">
    var table;
  </script>
  
  <div class="page-header">
    <h1>List Referral</h1>
  </div>  
  <div class="cover-input-group">
    <div class="row">
      <div class="input-group fl">
        <input type="text" id="from" class="form-control"> 
      </div>
      <div class="input-group fl">
        <p>hingga</p>
      </div>
      <div class="input-group fl">
        <input type="text" id="to" class="form-control"> 
      </div> 
    </div>
    <br>
    <div class="row">
      <div class="input-group fl">
        <label>Min. Refer</label>
      </div>
      <div class="input-group fl">
        <input type="number" id="minrefer" class="form-control" value="0" style="width:80px;"> 
      </div>
      <div class="input-group fl">
        <input type="button" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
      </div>   
    </div>
    
    <div class="none"></div>
  </div>

  <br>
  
  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  

  <br>

  <table class="table table-bordered" id="myTable">  
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Jumlah referral</th>
      </tr>      
    </thead>
  
    <tbody id="content"></tbody>
    
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
      table.destroy();

      $.ajax({                                      
        url: '<?php echo url('load-referral'); ?>',
        type: 'get',
        data: {
          page: page,
          from: $('#from').val(),
          to: $('#to').val(),
          status:$("#confirmed-status").val(),
          minrefer:$('#minrefer').val(),
        },
        beforeSend: function()
        {
          $("#div-loading").show();
        },
        dataType: 'text',
        success: function(result)
        {
          var data = jQuery.parseJSON(result);

          $('#content').html(data.view);
          
          table = $('#myTable').DataTable({
            searching: true,
            destroy: true,
            "order": [],
          });

          $("#div-loading").hide();
        }
      });
    }
    
    $(document).ready(function(){
      $("#alert").hide();
      table = $('#myTable').DataTable({
        searching: true,
        destroy: true,
        "order": [],
      });

      refresh_page(1);

      $(document).on('click', '#pagination a', function (e) {
        e.preventDefault();
        e.stopPropagation();
        if ($(this).html() == "«") {
          page -= 1; 
        } else 
        if ($(this).html() == "»") {
          page += 1; 
        } else {
          page = parseInt($(this).html());
        }
        //create_pagination(page);
        refresh_page(page);
      });
      $('#button-search').click(function(e){
        e.preventDefault();
        refresh_page(1);
      });

    });
  </script>		
  
@endsection
