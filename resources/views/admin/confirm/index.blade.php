@extends('layout.main')

@section('content')
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
        <th>Tanggal Konfirmasi</th>
        <th>NO Polis/SPAJ</th>
        <th>Member ID</th>
        <th>Nama Member</th>
        <th>No HP</th>
        <th>Email</th>
        <th>Jenis Premi</th>
        <th>Top up</th>
        <th>Jumlah</th>
        <th>Nama Bank / No rek Asal</th>
        <th>Nama Bank / No rek Tujuan</th>
        <th>Bukti Transfer</th>
        <th>Status</th>
        <?php if ($user->level==1) { ?>
          <th></th>
        <?php } ?>
      </tr>      
    </thead>
    
    
    <tbody id="content-firstpremi">
    </tbody>
    
  </table>  
  
  <nav>
    <ul class="pagination" id="pagination">
    </ul>
  </nav>  
  
  <div id="div-confirm">
  </div>
  
  <script>
     /*
          edit button 'onclick' call this function
          to open modal for edit purpose
     */
    
    function callEditConfirm(confirmId){
        $.ajax({
          url: '<?php echo url("edit-confirm"); ?>',
          type: 'get',
          data: {
            editId : confirmId,
          },
          beforeSend: function()
          {
              $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
              $("#div-confirm").html(result);
              $("#confirm-edit").modal();
              $("#div-loading").hide();
          }
        });
    }
      
      
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
          var from = $('#store_order_list_fromdate').datepicker('getDate');
          var to = $('#store_order_list_todate').datepicker('getDate');
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
        url: '<?php echo url('load-firstpremi'); ?>',
        type: 'get',
        data: {
          search : $("#search-text").val(),
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
          $('#content-firstpremi').html(result);
          $("#div-loading").hide();
        }
      });
    }
    function create_pagination()
    {
      $.ajax({
        url: '<?php echo url('pagination-firstpremi'); ?>',
        type: 'get',
        data: {
          search : $("#search-text").val(),
          from: ($('#from').datepicker('getDate').getTime()/1000+(3600*24+1)),
          to: ($('#to').datepicker('getDate').getTime()/1000+(3600*24+1)),
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
      $( "body" ).on( "click", ".x-icon", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('update-firstpremi'); ?>/'+$(this).attr('data-id'),
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
