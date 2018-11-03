@extends('layout.main')

@section('content')
  
  <div class="page-header">
    <h1>List User Perpanjang</h1>
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
    <div class="input-group fl">
      <input type="button" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
    <div align="right">
      Total perpanjang = <span id="span-total"></span><br>
      Total active = <span id="span-active"></span><br>
      Renewal rate = <span id="span-rate"></span>%
    </div>
    <div class="none"></div>
  </div>
	
  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
  <table class="table table-bordered" id="myTable">  
    <thead>
      <tr>
        <th>No. </th>
        <th>Email</th>
        <th>Name</th>
        <th>Created</th>
      </tr>      
    </thead>
    
    
    <tbody id="content">
    </tbody>
    
  </table>  
  
  <nav id="pagination">
  </nav>  
  
  <script>
    var table;

    function refresh_page(page)
    {
      table.destroy();
      $.ajax({                                      
        url: '<?php echo url('load-renewal'); ?>',
        type: 'get',
        data: {
          page: page,
          sort: $("#sort-by").val(),
					keyword: $("#keyword-search").val(),
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
          table = $('#myTable').DataTable({
                searching: false,
                destroy: true,
                "order": [],
                "columnDefs": [ {
                  "targets": [0],
                  "orderable": false
                } ],
            });

          $('#span-total').html(data.total);
          $('#span-active').html(data.active);
          $('#span-rate').html(data.rate);
          $("#div-loading").hide();
        }
      });
    }
    
    $(document).ready(function(){
      table = $('#myTable').DataTable({
        searching: false,
        destroy: true,
        "order": [],
        "columnDefs": [ {
          "targets": [0],
          "orderable": false
        } ],
      });
      $.fn.dataTable.moment( 'ddd, DD MMM YYYY' );

      //supaya nomor table nya nggak berubah
      table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
        });
      }).draw();

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
        
        refresh_page(page);
      });

      $('#button-search').click(function(e){
        e.preventDefault();
        
        refresh_page(1);
      });
    });
  </script>		
  
@endsection
