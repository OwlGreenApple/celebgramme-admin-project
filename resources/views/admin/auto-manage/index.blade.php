@extends('layout.main')

@section('content')
  <div class="page-header">
    <h1>History Posts</h1>
  </div>  
  <p>	
	* unfollow_wdfm = unfollow who dont follow me <br>
	dont_follow_su = dont follow same user <br>
	dont_follow_pu = dont follow private user <br>
	dont_comment_su = dont comment same user <br>
	usernames_whitelist = usernames unfollow whitelist
	
	</p>
  <div class="cover-input-group">
    <p>Filter tanggal 
    </p>
    <div class="input-group fl">
      <input type="text" id="from" class="form-control"> 
    </div>
    <div class="input-group fl">
      <p>hingga</p>
    </div>
    <div class="input-group fl">
      <input type="text" id="to" class="form-control"> 
    </div>  
    <div class="input-group fl">
    </div>  
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
	<p align="right">Total Setting Post yang perlu di update : {{$count_post}}</p>
  <table class="table table-bordered">  
    <thead>
      <tr>
        <th>No. </th>
        <th>Insta username</th>
        <th>Insta password</th>
        <th>Error Credential</th>
        <th>Updates</th>
        <th>Update terakhir</th>
        <th>Status</th>
      </tr>      
    </thead>
    
    
    <tbody id="content">
    </tbody>
    
  </table>  
  
  <nav id="pagination">
  </nav>  
	
  <div class="cover-input-group">
	  *buat copas ke keywords type (Relevant,)
    <div class="input-group fl">
    </div>  
	</div>  
  <div class="cover-input-group">
    <div class="input-group fl">
			<input type="text" class="form-control" placeholder="Keywords" id="keywords-excel">
    </div>  
    <div class="input-group fl">
			<input type="text" class="form-control" id="keywords-by" placeholder="Keywords type">
    </div>  
    <div class="input-group fl">
      <input type="button" value="Convert to excel" id="button-excel" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
  </div>  
	
  
  <script>
    $(function() {
      $("#from").datepicker({
        dateFormat: 'dd-mm-yy',
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
        onSelect: function(d) {
          var from = $('#from').datepicker('getDate');
          var to = $('#to').datepicker('getDate');
          if (from.getTime() > to.getTime()){
            $("#to").datepicker('setDate', from);
          }
        }
      });
      $("#from").datepicker('setDate', new Date());
      $("#to").datepicker('setDate', new Date());
    });
    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-post-auto-manage'); ?>',
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
    function create_pagination(page)
    {
      $.ajax({
        url: '<?php echo url('pagination-post-auto-manage'); ?>',
        type: 'get',
        data: {
          page : page,
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
      $('#button-excel').click(function(e){
        e.preventDefault();
        window.location="<?php echo url('create-excel'); ?>/"+$("#keywords-excel").val()+"/"+$("#keywords-by").val();
      });
      $('#button-search').click(function(e){
        e.preventDefault();
        create_pagination(1);
        refresh_page(1);
      });
      $( "body" ).on( "click", ".update-error", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('update-error-cred'); ?>/'+$(this).attr('data-id'),
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'patch',
          data: {
            _method : "PATCH",
          },
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            if (result=='success') {
              temp.removeClass('x-icon');
              temp.addClass('checked-icon');
            }
            $("#div-loading").hide();
          }
        });
      });
      $( "body" ).on( "click", ".update-status", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('update-auto-manage'); ?>/'+$(this).attr('data-id'),
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'patch',
          data: {
            _method : "PATCH",
          },
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            if (result=='success') {
              temp.removeClass('x-icon');
              temp.addClass('checked-icon');
            }
            $("#div-loading").hide();
          }
        });
      });
      
			$( "body" ).on( "click", ".see-update", function() {
				$(this).siblings('.data-updates').slideToggle();
			});
			$( "body" ).on( "click", ".see-all", function() {
				$(this).siblings('.data-all').slideToggle();
			});
			
    });
  </script>		
  
@endsection
