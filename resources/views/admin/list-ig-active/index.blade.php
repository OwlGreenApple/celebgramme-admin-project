@extends('layout.main')

@section('content')
  <div class="page-header">
    <h1>List Account IG Active</h1>
  </div>  

  <br>

  <div class="cover-input-group">
    <div class="input-group fl">
      <select class="form-control" name="server" id="server">
        <option>All</option>
        @foreach($arr as $data_arr)
          <option>{{$data_arr->meta_value}}</option>
        @endforeach
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
        <th>Username</th>
        <th>Cookies</th>
        <th>Server Automation</th>
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
        url: '<?php echo url('list-ig-active/load-account'); ?>',
        type: 'get',
        data: {
          page: page,
          server: $("#server").val(),
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