@extends('layout.main')

@section('content')
  <!-- Modal Show More -->  
  <div class="modal fade" id="show-more" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="header-more"></h4>
        </div>
        <div class="modal-body">
          <span id="content-more"></span>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

  <div class="page-header">
    <h1>Confirm payment</h1>
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
      <label class="label-slicing">Confirmed by user : </label>
    </div>
    <div class="input-group fl">
      <select class="form-control" id="confirmed-status">
        <option value="1">Confirmed</option>
        <option value="0">Not Confirmed</option>
        <option value="2">All</option>
      </select>
    </div>
    <div class="none"></div>
  </div>
  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="text" id="search-text" class="form-control" placeholder="keyword"> 
    </div>
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
        <th>No.</th>
        <th>Confirmed by user</th>
        <th>Tanggal Konfirmasi / No Order</th>
        <th>Nama bank</th>
        <th>No rekening</th>
        <th>Nama pemilik rekening</th>
        <th>Email</th>
        <!--<th>Nilai yang dikonfirmasi (Rp)</th>-->
        <th>Order Total (Rp)</th>
        <!--<th>Coupon</th>-->
        <!--<th>package daily likes</th>-->
        <th>Package Type</th>
        <th>Bukti Transfer</th>
        <th>Status</th>
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
        url: '<?php echo url('load-payment'); ?>',
        type: 'get',
        data: {
          search : $("#search-text").val(),
          page: page,
          from: ($('#from').datepicker('getDate').getTime()/1000+(3600*24+1)),
          to: ($('#to').datepicker('getDate').getTime()/1000+(3600*24+1)),
          status:$("#confirmed-status").val(),
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
        url: '<?php echo url('pagination-payment'); ?>',
        type: 'get',
        data: {
					page : page,
          search : $("#search-text").val(),
          from: ($('#from').datepicker('getDate').getTime()/1000+(3600*24+1)),
          to: ($('#to').datepicker('getDate').getTime()/1000+(3600*24+1)),
          username : $("#username").val(),
          status:$("#confirmed-status").val(),
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
    $(document).ready(function(){
      $("#alert").hide();
      refresh_page(1);
      //create_pagination();

       $("#show-more").on("show.bs.modal", function(e) {
        var id = $(e.relatedTarget).data('id');
        var action = $(e.relatedTarget).data('action');
        var header = $(e.relatedTarget).data('header');

        $.ajax({
          url: '<?php echo url('show-more'); ?>',
          type: 'get',
          data: {
            id:id,
            action:action,
          },
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            $("#div-loading").hide();
            $("#header-more").html(header);
            $("#content-more").html(result);
          }
        });
      });


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
        //create_pagination();
        refresh_page(1);
      });
      $( "body" ).on( "click", ".x-icon", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('update-payment'); ?>/'+$(this).attr('data-id'),
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

      $( "body" ).on( "click", ".popup-newWindow", function() {
        event.preventDefault();
        window.open($(this).find("img").attr("src"), "popupWindow", "width=600,height=600,scrollbars=yes");
      });

    });
  </script>		
  
@endsection
