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
        <th>IP Login</th>
        <th>IP Activity</th>
        <th>Status</th>
        <th>Created </th>
      </tr>      
    </thead>
    
    
    <tbody id="content">
    </tbody>
    
  </table>  
  
  <nav id="pagination2">
  </nav>  
	
  <script>
    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-log-setting'); ?>',
        type: 'get',
        data: {
          page: page,
					keyword: $("#keyword-search").val(),
					// filename: $("#file-name").val(),
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
			
    });
  </script>		
  
@endsection
