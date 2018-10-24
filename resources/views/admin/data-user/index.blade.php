@extends('layout.main')

@section('content')
  
  <div class="page-header">
    <h1>Data User</h1>
  </div>  
  <div class="cover-input-group">
    <p>Sort By</p>
    <div class="input-group fl">
      <select class="form-control" id="sort-by">
				<option value="1"> Created </option>
				<option value="2"> Auto Manage </option>
      </select>
    </div>
    <div class="input-group fl">
			<input type="text" id="keyword-search" class="form-control" placeholder="Email">
    </div>
    <div class="none"></div>
  </div>

  <div class="cover-input-group">
    <p>Status</p>
    <div class="input-group fl">
      <select class="form-control" id="status_user" name="status_user">
        <option>All</option>
        <option>Time Out Activfans</option>
        <option>Time Out Activpost</option>
        <option>Not Active Activfans</option>
        <option>Not Active Activpost</option>
        <option>Active</option>
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
  <table class="table table-bordered">  
    <thead>
      <tr>
        <th>No. </th>
        <th>Email</th>
        <th>Name</th>
        <th>Created</th>
        <th>Time Activfans (days)</th>
        <th>Time Activpost (days)</th>
      </tr>      
    </thead>
    
    
    <tbody id="content">
    </tbody>
    
  </table>  
  
  <nav id="pagination">
  </nav>  
  
  <script>
    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-data-user'); ?>',
        type: 'get',
        data: {
          page: page,
          sort: $("#sort-by").val(),
					keyword: $("#keyword-search").val(),
          status_user : $("#status_user").val(),
          // from: ($('#from').datepicker('getDate').getTime()/1000+(3600*24+1)),
          // to: ($('#to').datepicker('getDate').getTime()/1000+(3600*24+1)),
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
          $('#pagination').html(data.pagination);
          $("#div-loading").hide();
        }
      });
    }
    function create_pagination(page)
    {
      $.ajax({
        url: '<?php echo url('pagination-member-all'); ?>',
        type: 'get',
        data: {
          page : page,
          sort: $("#sort-by").val(),
					keyword: $("#keyword-search").val(),
          // from: ($('#from').datepicker('getDate').getTime()/1000+(3600*24+1)),
          // to: ($('#to').datepicker('getDate').getTime()/1000+(3600*24+1)),
        },
        beforeSend: function()
        {
          $("#div-loading").show();
        },
        dataType: 'text',
        success: function(result)
        {
          $('#pagination').html(result);
      
          // $("#div-loading").hide();
        }
      });
    }
    function give_bonus(formVar){
        $.ajax({                                      
          url: '<?php echo url('give-bonus'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: formVar,
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            var data = jQuery.parseJSON(result);
            if(data.type=='success') {
              if(data.action=='auto') {
                $(".row"+data.id).find(".total-auto-manage").html(data.view);
              }
              if(data.action=='daily') {
                $(".row"+data.id).find(".total-balance").html(data.view);
              }
            }
            $("#div-loading").hide();
          }
        });
    }
    $(document).ready(function(){
      $("#alert").hide();
      //create_pagination(1);
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

      $( "body" ).on( "click", "#button-list-member", function() {
        window.location="<?php echo url('list-rico-excel'); ?>";
      });
			
      $('#button-search').click(function(e){
        e.preventDefault();
        //create_pagination(1);
        refresh_page(1);
      });
      $( "body" ).on( "click", ".btn-update", function() {
        $(".user-id").val($(this).attr("data-id"));
        $("#emailedit").val($(this).attr("data-email"));
        $("#fullnameedit").val($(this).attr("data-nama"));
      });
      $( "body" ).on( "click", ".btn-delete", function() {
				$("#id-member-delete").val($(this).attr("data-id"));
      });
      $( "body" ).on( "click", "#button-delete", function() {
        $.ajax({                                      
          url: '<?php echo url('delete-member'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: {
						id : $("#id-member-delete").val(),
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
              //create_pagination(1);
              refresh_page(1);
            }
            $("#div-loading").hide();
          }
        });
      });
			
      // $( "body" ).on( "click", ".btn-daily-like", function() {
        // $(".user-id").val($(this).attr("data-id"));
        // $(".action").val("daily");
        // $("#daily-likes").val("");
        // $("#valid-until").val("");
      // });
			
      $( "body" ).on( "click", ".btn-auto-manage", function() {
        $(".user-id").val($(this).attr("data-id"));
        $(".action").val("auto");
        $("#active-days").val("");
      });
      $( "body" ).on( "click", ".button-process", function() {
        temp = $(this);
        if (temp.attr("data-check")=="auto") { formVar = $("#form-give-auto").serialize(); }
        if (temp.attr("data-check")=="daily") { formVar = $("#form-give-daily").serialize(); }
        
        
        give_bonus(formVar);
      });

      $( "body" ).on( "click", "#btn-create-member", function() {

					var uf = $('#form-create-member');
					var fd = new FormData(uf[0]);
        $.ajax({
          url: '<?php echo url('add-member'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          // data: $("#form-create-member").serialize(),
          data : fd,
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
					processData:false,
					contentType: false,
					
          success: function(result)
          {
            var data = jQuery.parseJSON(result);
            $("#alert").show();
            $("#alert").html(data.message);
            if(data.type=='success') {
              //create_pagination(1);
              refresh_page(1);
              $("#alert").addClass("alert-success");
              $("#alert").removeClass("alert-danger");
							$("#select-order option[value='"+data.orderid+"']").remove();
            } else if (data.type=='error') {
              $("#alert").addClass("alert-danger");
              $("#alert").removeClass("alert-success");
            }
            $("#div-loading").hide();
          }
        });


      });

			$( "body" ).on( "click", ".btn-refund", function() {
        $('#id_refund').val($(this).attr('data-id'));
      });

      $( "body" ).on( "click", "#btn-refund-ok", function() {
        $.ajax({
          url: "{{url('submit-refund')}}",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data:  $('#formrefund').serialize(),
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
              //create_pagination(1);
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

      $( "body" ).on( "click", "#btn-bonus-member", function() {
					var uf = $('#form-bonus-member');
					var fd = new FormData(uf[0]);
        $.ajax({
          url: '<?php echo url('bonus-member'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data : fd,
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
					processData:false,
					contentType: false,
					
          success: function(result)
          {
            var data = jQuery.parseJSON(result);
            $("#alert").show();
            $("#alert").html(data.message);
            if(data.type=='success') {
              //create_pagination(1);
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
			
      $( "body" ).on( "click", "#btn-add-rico", function() {
					var uf = $('#form-add-rico');
					var fd = new FormData(uf[0]);
        $.ajax({
          url: '<?php echo url('add-member-rico'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data : fd,
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
					processData:false,
					contentType: false,
					
          success: function(result)
          {
            var data = jQuery.parseJSON(result);
            $("#alert").show();
            $("#alert").html(data.message);
            if(data.type=='success') {
              //create_pagination(1);
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
			
      $( "body" ).on( "click", "#btn-edit-member", function() {

        $.ajax({
          url: '<?php echo url('edit-member'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-edit-member").serialize(),
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
              //create_pagination(1);
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

      $( "body" ).on( "click", ".btn-max-account", function() {
        $(".user-id").val($(this).attr("data-id"));
        $('#max-account-user').val($(this).attr("data-account"));
      });
      $( "body" ).on( "click", ".btn-edit-email", function() {
        $("#id-edit").val($(this).attr("data-id"));
        $("#edit-email-input").val($(this).attr("data-email"));
      });
      $( "body" ).on( "click", "#btn-edit-email-ok", function() {
        $.ajax({
          url: '<?php echo url('edit-email'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-edit-email").serialize(),
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
              //create_pagination(1);
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
      $( "body" ).on( "click", ".btn-check-login-websta", function() {
        $(".user-id").val($(this).attr("data-id"));
				if ($(this).attr("data-test")==1) {
					$("#radio-login-websta").prop("checked", true);
				}
				if ($(this).attr("data-test")==0) {
					$("#radio-login-api").prop("checked", true);
				}
      });
      $( "body" ).on( "click", "#btn-edit-login-webstame", function() {

        $.ajax({
          url: '<?php echo url('edit-member-login-webstame'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-edit-login-webstame").serialize(),
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
              //create_pagination(1);
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

      $( "body" ).on( "click", "#btn-edit-max-account", function() {

        $.ajax({
          url: '<?php echo url('edit-member-max-account'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: $("#form-edit-max-account").serialize(),
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

			
      $( "body" ).on( "click", ".btn-order-package", function() {
				$(".user-id").val($(this).attr("data-id"));
      });
      $( "body" ).on( "click", "#btn-process-order", function() {
        $.ajax({                                      
          url: '<?php echo url('member-order-package'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
					data: $("#form-order-package").serialize(),
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
              //create_pagination(1);
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
			
      $( "body" ).on( "click", "#button-add-order", function() {
        $(".user-id").val($(this).attr("data-id"));
      });
      $( "body" ).on( "click", "#btn-add-order-ok", function() {
        var form = $('#form-add-order')[0];
        var formData = new FormData(form);

        $.ajax({                                      
          url: '<?php echo url('add-order-excel'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
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
              //create_pagination(1);
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
      
      $( "body" ).on( "click", ".btn-time-logs", function() {
        temp = $(this);
				$("#time-log-div").html("");
        $.ajax({                                      
          url: '<?php echo url('load-time-logs'); ?>',
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
							$("#time-log-div").html('<table class="table table-bordered table-data-default">  <thead>	<tr style="font-weight:bold;"><th>Date time</th><th>Sisa waktu</th></tr>      </thead><tbody id="p-logs"></tbody></table>  ');
							$("#p-logs").html(data.logs);
							$('.table-data-default').DataTable();
            } else if (data.type=='error') {
            }
						$("#div-loading").hide();
          }
        });
      });


			$(".type-excel").hide();
			$('#select-input').on('change', function() {
				// alert( this.value ); // or $(this).val()
				// alert( $(this).val() ); // or $(this).val()
				if ($(this).val()=="manual") {
					$(".type-manual").show();
					$(".type-excel").hide();
				}
				if ($(this).val()=="excel") {
					$(".type-manual").hide();
					$(".type-excel").show();
				}
			});			
			
    });
  </script>		
  
@endsection
