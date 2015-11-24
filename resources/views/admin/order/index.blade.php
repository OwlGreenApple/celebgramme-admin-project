@extends('layout.main')

@section('content')
  <div class="page-header">
    <h1>Order List</h1>
  </div>  
  
  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
  <table class="table table-bordered">  
    <thead>
      <tr>
        <th>No. </th>
        <th>No Order</th>
        <th>Subtotal</th>
        <th>Shipment fee</th>
        <th>Total</th>
        <th>Payment Method</th>
        <th>Customer</th>
        <th>Shipping number</th>
        <th>Invoice ID</th>
        <th>Payment Status</th>
        <th>Shipping Status</th>
        <th>Created</th>
        <th></th>
      </tr>      
    </thead>
    
    
    <tbody id="content">
    </tbody>
    
  </table>  
  
  <nav id="pagination">
  </nav>  
  
  <div id="div-popup">
  </div>
  
  <script>
     /*
          edit button 'onclick' call this function
          to open modal for edit purpose
     */
    
    function callEdit(vorderId){
        $.ajax({
          url: '<?php echo url("edit-order"); ?>',
          type: 'get',
          data: {
            orderId : vorderId,
          },
          beforeSend: function()
          {
              $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
              $("#div-popup").html(result);
              $("#edit-show").modal();
              $("#div-loading").hide();
          }
        });
    }

    function callDetail(vorderId){
        $.ajax({
          url: '<?php echo url("detail-order"); ?>',
          type: 'get',
          data: {
            orderId : vorderId,
          },
          beforeSend: function()
          {
              $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
              $("#div-popup").html(result);
              $("#detail-show").modal();
              $("#div-loading").hide();
          }
        });
    }
    
      
    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-order'); ?>',
        type: 'get',
        data: {
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
        url: '<?php echo url('pagination-order'); ?>',
        type: 'get',
        data: {
          page : page,
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
    });
  </script>		
  
@endsection
