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

  <div class="modal fade" id="myModalLog" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">History Logs</h4>
        </div>
        <div class="modal-body">
					<div class="form-group form-group-sm row">
						<p id="p-logs" style="margin-left:10px;"></p>
					</div>  
        </div>
        <div class="modal-footer">
        </div>
      </div>
      
    </div>
  </div>


  <div class="modal fade" id="myModalDaily" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">History Logs Daily</h4>
        </div>
        <div class="modal-body">
					<div class="form-group form-group-sm row">
						<table class="table table-bordered">  
							<thead>
								<tr style="font-weight:bold;">
									<th>Date time</th>
									<th>Unfollows counter</th>
									<th>Follows counter</th>
									<th>Likes Counter</th>
									<th>Comments Counter</th>
								</tr>      
							</thead>
							<tbody id="p-logs-daily">
							</tbody>
							
						</table>  
						
						
					</div>  
        </div>
        <div class="modal-footer">
        </div>
      </div>
      
    </div>
  </div>


  <div class="modal fade" id="myModalHourly" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">History Logs Hourly</h4>
        </div>
        <div class="modal-body">
					<div class="form-group form-group-sm row">
						<table class="table table-bordered">  
							<thead>
								<tr style="font-weight:bold;">
									<th>Date time</th>
									<th>Unfollows counter</th>
									<th>Follows counter</th>
									<th>Likes Counter</th>
									<th>Comments Counter</th>
								</tr>      
							</thead>
							<tbody id="p-logs-hourly">
							</tbody>
							
						</table>  
					</div>  
        </div>
        <div class="modal-footer">
        </div>
      </div>
      
    </div>
  </div>



	
  <div class="page-header">
    <h1>Daily IG Automation</h1>
  </div>  
  <div class="cover-input-group">
    <div class="input-group fl">
			<input type="text" id="keyword-search" class="form-control" placeholder="insta username" value="{{$search}}">
		</div>  
    <div class="input-group fl">
      <input type="text" id="from" class="form-control"> 
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
        <th>Insta username / Start time</th>
        <th>Followers</th>
        <th>Following</th>
        <th>Unfollows</th>
        <th>Follows</th>
        <th>Likes</th>
        <th>Comments</th>
        <th>Status Cookies</th>
        <th>Activity Speed</th>
				
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
      $("#from").datepicker('setDate', new Date());
    });
    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-automation-daily'); ?>',
        type: 'get',
        data: {
          page: page,
					keyword: $("#keyword-search").val(),
					// filename: $("#file-name").val(),
					from: ($('#from').datepicker('getDate').getTime()/1000+(3600*24)),
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
        url: '<?php echo url('pagination-automation-daily'); ?>',
        type: 'get',
        data: {
          page : page,
					keyword: $("#keyword-search").val(),
					from: ($('#from').datepicker('getDate').getTime()/1000+(3600*24)),
					// filename: $("#file-name").val(),
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
			
			
      $( "body" ).on( "click", ".btn-show-log", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('load-automation-logs'); ?>',
          type: 'get',
          data: {
						id : $(this).attr("data-id")
					},
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            var data = jQuery.parseJSON(result);
            if(data.type=='success') {
							$("#p-logs").html(data.logs);
            } else if (data.type=='error') {
            }
						$("#div-loading").hide();
          }
        });
      });

			
      $( "body" ).on( "click", ".btn-show-log-daily", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('load-automation-logs-daily'); ?>',
          type: 'get',
          data: {
						id : $(this).attr("data-id")
					},
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            var data = jQuery.parseJSON(result);
            if(data.type=='success') {
							$("#p-logs-daily").html(data.logs);
            } else if (data.type=='error') {
            }
						$("#div-loading").hide();
          }
        });
      });

			
      $( "body" ).on( "click", ".btn-show-log-hourly", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('load-automation-logs-hourly'); ?>',
          type: 'get',
          data: {
						id : $(this).attr("data-id")
					},
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            var data = jQuery.parseJSON(result);
            if(data.type=='success') {
							$("#p-logs-hourly").html(data.logs);
            } else if (data.type=='error') {
            }
						$("#div-loading").hide();
          }
        });
      });

			
    });
  </script>		
  
@endsection
