@extends('layout.main')

@section('content')
  <div class="page-header">
    <h1>History Posts</h1>
  </div>  
  <p></p>
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
    <div class="none"></div>
  </div>
  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="text" id="keyword" class="form-control" placeholder="keyword"> 
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
        <th>No. </th>
        <th>URL Photo</th>
        <th>Likes</th>
        <th>Email user</th>
        <th>Nama</th>
        <th>Phone user</th>
        <th>Status</th>
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
      $("#from").datepicker('setDate', new Date());
      $("#to").datepicker('setDate', new Date());
    });
    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-post'); ?>',
        type: 'get',
        data: {
          page: page,
          from: ($('#from').datepicker('getDate').getTime()/1000+(3600*24+1)),
          to: ($('#to').datepicker('getDate').getTime()/1000+(3600*24+1)),
          search : $("#keyword").val(),
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
        url: '<?php echo url('pagination-post'); ?>',
        type: 'get',
        data: {
          page : page,
          from: ($('#from').datepicker('getDate').getTime()/1000+(3600*24+1)),
          to: ($('#to').datepicker('getDate').getTime()/1000+(3600*24+1)),
          search : $("#keyword").val(),
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
      $( "body" ).on( "click", ".x-icon", function() {
        temp = $(this);
        $.ajax({                                      
          url: '<?php echo url('update-post'); ?>/'+$(this).attr('data-id'),
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
      
    });
  </script>		
  
@endsection
