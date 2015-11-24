@extends('layout.main')

@section('content')
  <div class="page-header">
    <h1>Confirm payment List</h1>
  </div>  
  
  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
  <table class="table table-bordered">  
    <thead>
      <tr>
        <th>No. </th>
        <th>No Order</th>
        <th>Nama</th>
        <th>Metode Pembayaran</th>
        <th>Jumlah Transfer</th>
        <th>description</th>
        <th>file upload</th>
        <th>Created</th>
        <th>Status</th>
        <th></th>
      </tr>      
    </thead>
    
    
    <tbody id="content">
    </tbody>
    
  </table>  
  
  <nav id="pagination">
  </nav>  
  
  
  <div id="div-confirm">
  </div>
  
  <script>
     /*
          edit button 'onclick' call this function
          to open modal for edit purpose
     */
    
    function callEditConfirm(vnoOrder){
        $.ajax({
          url: '<?php echo url("check-order-confirm"); ?>',
          type: 'get',
          data: {
            noOrder : vnoOrder,
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
    
      
      
    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-confirm-payment'); ?>',
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
        url: '<?php echo url('pagination-confirm-payment'); ?>',
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
    
    function verify_payment(id,vtotal,vpaymentMethod,vaction) {
        $.ajax({                                      
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '<?php echo url('confirm-payment'); ?>',
          type: 'post',
          data: {
            confirmId: id,
            total: vtotal,
            paymentMethod: vpaymentMethod,
            action: vaction,
          },
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
            if(data.type=='success')
            {
              $("#alert").addClass('alert-success');
              $("#alert").removeClass('alert-danger');
            }
            else if(data.type=='error')
            {
              $("#alert").addClass('alert-danger');
              $("#alert").removeClass('alert-success');
            }
            $("#status-"+id).html('<i class="checked-icon"></i>');
            $("#div-loading").hide();
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
      $("body").on('click', '.x-icon',function(e) {
        id = $(this).attr("data-id");
        total = $(this).attr("data-total");
        verify_payment(id,total,"bank_transfer","");
      });
      $("body").on('click', '.btn-veritrans-accept',function(e) {
        id = $(this).attr("data-id");
        total = $(this).attr("data-total");
        verify_payment(id,total,"veritrans","accept");
      });
      $("body").on('click', '.btn-veritrans-deny',function(e) {
        id = $(this).attr("data-id");
        total = "";
        verify_payment(id,total,"veritrans","deny");
      });
    });
  </script>		
  
@endsection
