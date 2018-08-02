@extends('layout.main')

@section('content')
  <div class="page-header">
    <h1>List Add Account</h1>
  </div>  

  <br>

  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="text" name="tanggal" id="tanggal" class="form-control"> 
    </div> 
    <div class="none"></div>
  </div>

  <div class="cover-input-group">
    <div class="input-group fl">
      <select class="form-control" name="status" id="status">
        <option value="success">Success</option>
        <option value="error">Error</option>
      </select>
    </div>
    <div class="none"></div>
  </div>

  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="button" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
    <div class="none"></div>
    <div align="right">
      Total = <span id="total">0</span>
    </div>
  </div>

  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
  
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
  
  <nav id="pagination">
  </nav>  
  
  <script>
    $(function() {
      $("#tanggal").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
      });
      $("#tanggal").datepicker('setDate', new Date());
    });

    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('list-add-account/load-account'); ?>',
        type: 'get',
        data: {
          page: page,
          status: $("#status").val(),
          tanggal: $('#tanggal').val(),
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
          $('#total').html(data.count);
          $("#div-loading").hide();
        }
      });
    }

    $(document).ready(function(){
      $("#alert").hide();
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
      
      $('#button-search').click(function(e){
        e.preventDefault();
        refresh_page(1);
      });
      
    });
  </script>   
  
@endsection