@extends('layout.main')

@section('content')
<style type="text/css">
  .ui-datepicker-calendar {
    display: none;
  }
</style>
  <div class="page-header">
    <h1>List Success Order</h1>
  </div>  

  <br>

  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="text" name="bulan" id="bulan" class="form-control"> 
    </div> 
    <div class="none"></div>
  </div>

  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="button" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
    <div class="none"></div>
    <div align="right">
      Total = <span id="total_order"></span>
    </div>
  </div>

  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
  
  <table class="table table-bordered">  
    <thead>
      <tr style="font-weight:bold;">
        <th>No. </th>
        <th>No Order</th>
        <th>Type</th>
        <th>Status</th>
        <th>Total</th>
        <th>Discount</th>
        <th>Updated_at</th>
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
        url: '<?php echo url('success-order/load-order'); ?>',
        type: 'get',
        data: {
          page: page,
          bulan: $("#bulan").val(),
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
          $('#total_order').html('Rp. '+$('#total').val());
          $("#div-loading").hide();
        }
      });
    }

    $(document).ready(function(){
      $("#alert").hide();
      refresh_page(1);
      
      $("#bulan").datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy-mm',
        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
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
        refresh_page(1);
      });
      
    });
  </script>   
  
@endsection