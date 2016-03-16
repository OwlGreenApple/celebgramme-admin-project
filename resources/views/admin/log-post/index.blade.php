@extends('layout.main')

@section('content')
<style>
	.wrap{
		// white-space: pre-wrap;      /* CSS3 */   
		// white-space: -moz-pre-wrap; /* Firefox */    
		// white-space: -pre-wrap;     /* Opera <7 */   
		// white-space: -o-pre-wrap;   /* Opera 7 */    
		word-wrap: break-word;      /* IE */		
		width:350px;
	}
</style>

  <!-- Modal confirmation-->
	<div class="modal fade" id="confirm-dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
									Confirmation Box
							</div>
							<div class="modal-body">
									Are you sure want to this ?
							</div>
							<input type="hidden" id="id-order-delete">
							<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" data-dismiss="modal" class="btn btn-danger btn-ok" id="button-yes" data-action="">Yes</button>
							</div>
					</div>
			</div>
	</div>	



	
	

  <div class="page-header">
    <h1>Admin Log Posts</h1>
  </div>  
  <p>	
	* unfollow_wdfm = unfollow who dont follow me <br>
	dont_follow_su = dont follow same user <br>
	dont_follow_pu = dont follow private user <br>
	dont_comment_su = dont comment same user <br>
	usernames_whitelist = usernames unfollow whitelist <br>
	C1 : \\23.250.113.28\Users\Administrator\Documents\Follow Liker\import <br>
	C2 : \\198.52.129.10\Users\Administrator\Documents\Follow Liker\import
	
	
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
			<input type="text" id="keyword-search" class="form-control" placeholder="insta username / admin name">
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
  <table class="table table-bordered">  
    <thead>
      <tr>
        <th>No. </th>
        <th>Taken By Admin</th>
        <th>Insta Username</th>
        <th>Update time</th>
        <th>Updates</th>
      </tr>      
    </thead>
    
    
    <tbody id="content">
    </tbody>
    
  </table>  
  
  <nav id="pagination">
  </nav>  
	
	
  
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
			date = new Date();
			date.setMonth(date.getMonth() , 1);
      $("#from").datepicker('setDate', date);
      $("#to").datepicker('setDate', new Date());
    });
    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-log-post'); ?>',
        type: 'get',
        data: {
          page: page,
          from: ($('#from').datepicker('getDate').getTime()/1000+(3600*24+1)),
          to: ($('#to').datepicker('getDate').getTime()/1000+(3600*24+1)),
					keyword: $("#keyword-search").val(),
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
        url: '<?php echo url('pagination-log-post'); ?>',
        type: 'get',
        data: {
          page : page,
          from: ($('#from').datepicker('getDate').getTime()/1000+(3600*24+1)),
          to: ($('#to').datepicker('getDate').getTime()/1000+(3600*24+1)),
					keyword: $("#keyword-search").val(),
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
			
      $('#button-search').click(function(e){
        e.preventDefault();
        create_pagination(1);
        refresh_page(1);
      });

			$( "body" ).on( "click", ".see-update", function(e) {
				e.preventDefault();
				$(this).siblings('.data-updates').slideToggle();
			});
			$( "body" ).on( "click", ".see-all", function(e) {
				e.preventDefault();
				$(this).siblings('.data-all').slideToggle();
			});
			
			
    });
  </script>		
  
@endsection
