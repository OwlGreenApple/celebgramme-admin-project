@extends('layout.main')

@section('content')
<style>
	.wrap{
		white-space: pre-wrap;      /* CSS3 */   
		white-space: -moz-pre-wrap; /* Firefox */    
		white-space: -pre-wrap;     /* Opera <7 */   
		white-space: -o-pre-wrap;   /* Opera 7 */    
		word-wrap: break-word;      /* IE */		
		width:350px;
	}
.ui-autocomplete {
    z-index:9050!important;
}	
</style>
  <div class="page-header">
    <h1>IP Flow</h1>
  </div>  
	<br>
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
			<input type="text" id="keyword-search" class="form-control" placeholder="insta username" value="{{$search}}">
		</div>  
		<!--
    <div class="input-group fl">
			<select class="form-control" id="file-name">
				<option value="all">All</option>
				<option value="-">-</option>
			</select>
		</div>  
		-->
    <div class="none"></div>
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
  <nav id="pagination1">
  </nav>  
  <table class="table table-bordered">  
    <thead>
      <tr style="font-weight:bold;">
        <th>No. </th>
        <th>Email</th>
        <th>Description</th>
        <th>Created </th>
      </tr>      
    </thead>
    
    
    <tbody id="content">
    </tbody>
    
  </table>  
  
  <nav id="pagination2">
  </nav>  
	
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
        url: '<?php echo url('load-log-setting'); ?>',
        type: 'get',
        data: {
          page: page,
					keyword: $("#keyword-search").val(),
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
    function create_pagination(page)
    {
      $.ajax({
        url: '<?php echo url('pagination-log-setting'); ?>',
        type: 'get',
        data: {
          page : page,
					keyword: $("#keyword-search").val(),
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
          $('#pagination1').html(result);
          $('#pagination2').html(result);
          
          $('#pagination1 a').click(function(e){
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
            create_pagination(page);
            refresh_page(page);
          });
					
          $('#pagination2 a').click(function(e){
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
            create_pagination(page);
            refresh_page(page);
          });
          
          // $("#div-loading").hide();
        }
      });
    }
    $(document).ready(function(){
      $("#alert").hide();
      create_pagination(1);
      refresh_page(1);
			
			
      $('#button-search').click(function(e){
        e.preventDefault();
        create_pagination(1);
        refresh_page(1);
      });
			
    });
  </script>		
  
@endsection
