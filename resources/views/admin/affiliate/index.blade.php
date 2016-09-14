@extends('layout.main')

@section('content')
  <!-- Modal Add affiliate-->
	<div class="modal fade" id="modal-affiliate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
									Add / Edit Affiliate
							</div>
							<div class="modal-body">
								<form enctype="multipart/form-data" id="form-affiliate">
									<div class="form-group form-group-sm row">
										<label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">nama</label>
										<div class="col-sm-8 col-md-6">
											<input type="text" class="form-control" placeholder="nama affiliate" name="nama" id="nama">
										</div>
									</div>
									<div class="form-group form-group-sm row">
										<label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Page Link Affiliate</label>
										<div class="col-sm-8 col-md-6">
											<input type="text" class="form-control" placeholder="Link affiliate" name="link" id="link">
										</div>
									</div>
									<div class="form-group form-group-sm row">
										<label class="col-xs-8 col-sm-2 control-label" for="formGroupInputSmall">Jumlah hari affiliate</label>
										<div class="col-sm-8 col-md-6">
											<input type="number" class="form-control" placeholder="jumlah free days" name="jumlah_hari_affiliate" id="jumlah-hari">
										</div>
									</div>
									<input type="hidden" class="" name="id_affiliate" id="id-affiliate">
								</form>
									
							</div>
							<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" data-dismiss="modal" class="btn btn-default btn-ok" id="button-submit-affiliate">Submit</button>
							</div>
					</div>
			</div>
	</div>	
	
  <!-- Modal confirm delete-->
	<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
									Delete Affiliate
							</div>
							<div class="modal-body">
									Are you sure want to delete ?
							</div>
							<input type="hidden" id="id-affiliate-delete">
							<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" data-dismiss="modal" class="btn btn-danger btn-ok" id="button-delete">Delete</button>
							</div>
					</div>
			</div>
	</div>	
	
  <div class="page-header">
    <h1>Affiliate List</h1>
  </div>  
  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="text" id="search-text" class="form-control" placeholder="keyword"> 
    </div>
    <div class="input-group fl">
      <input type="button" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
    <div class="input-group fl">
      <input type="button" value="Add" id="button-add" data-loading-text="Loading..." class="btn btn-primary" data-toggle="modal" data-target="#modal-affiliate"> 
    </div>  
    <div class="none"></div>
  </div>
  
  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
  <table class="table table-bordered">  
    <thead>
      <tr>
        <th>No.</th>
        <th>Nama</th>
        <th>Link Wuoymembership</th>
        <th>Jumlah hari free trial</th>
        <th>Jumlah user daftar</th>
        <th>Jumlah user beli</th>
        <th>Created</th>
        <th></th>
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
      
    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-affiliate'); ?>',
        type: 'get',
        data: {
          search : $("#search-text").val(),
          page: page,
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
        url: '<?php echo url('pagination-affiliate'); ?>',
        type: 'get',
        data: {
					page : page,
          search : $("#search-text").val(),
          username : $("#username").val(),
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
      refresh_page(1);
      create_pagination();
      $('#button-search').click(function(e){
        e.preventDefault();
        create_pagination();
        refresh_page(1);
      });

      $( "body" ).on( "click", ".btn-delete", function() {
				$("#id-affiliate-delete").val($(this).attr("data-id"));
      });
      $( "body" ).on( "click", "#button-delete", function() {
        $.ajax({                                      
          url: '<?php echo url('delete-affiliate'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: {
						id : $("#id-affiliate-delete").val(),
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
              create_pagination(1);
              refresh_page(1);
            }
            $("#div-loading").hide();
          }
        });
      });
      $('#button-add').click(function(e){
        e.preventDefault();
        $("#id-affiliate").val("new");
      });
      $( "body" ).on( "click", ".button-edit", function() {
        $("#id-affiliate").val($(this).attr("data-id"));
        $("#nama").val($(this).attr("data-nama"));
        $("#link").val($(this).attr("data-link"));
        $("#jumlah-hari").val($(this).attr("data-hari"));
      });
      $( "body" ).on( "click", "#button-submit-affiliate", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('add-affiliate'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-affiliate").serialize(),
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            var data = jQuery.parseJSON(result);
            $("#alert").show();
            $("#alert").html(data.message);
            if(data.type=='success') {
              create_pagination(1);
              refresh_page(1);
              $("#alert").addClass("alert-success");
              $("#alert").removeClass("alert-danger");
            } else if (data.type=='error') {
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
