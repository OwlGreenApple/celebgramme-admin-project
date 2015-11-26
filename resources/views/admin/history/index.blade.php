@extends('layout.main')

@section('content')
  <div class="page-header">
    <h1>Proses Ranking Member</h1>
  </div>  
  <p>Yang ditampilkan hanya member yang sudah mensponsori 2 orang atau lebih. 1 PNR = Rp {{number_format($configuration->pnr,0,'','.')}}</p>
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
      <input type="text" id="username" class="form-control" placeholder="username"> 
    </div>
    <div class="input-group fl">
      <input type="button" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
    <div class="input-group fl">
      <input type="button" value="Process" id="button-generate" data-loading-text="Loading..." class="btn btn-primary">
    </div>  
    <div class="none"></div>
  </div>
  
  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
  <table class="table table-bordered">  
    <thead>
      <tr>
        <th rowspan="3">No</th>
        <th rowspan="3">Member ID</th>
        <th rowspan="3">Sponsor</th>
        <th colspan="6">LEFT PNR</th>
        <th colspan="6">RIGHT PNR</th>
        <th rowspan="3">Match<br>Aktif-2</th>
        
        <th rowspan="3">Flush</th>
        <th rowspan="3">Rangking</th>
        <th colspan="4">Carry<br>Forward</th>
        <th rowspan="3">Bonus</th>
        <th rowspan="3">Status</th>
        <th rowspan="3">Ket</th>
      </tr>
      <tr>
        <th colspan="4">Total Pending<br> Kiri</th>
        <th colspan="2">Aktif-2+<br>Aktif-3</th>
        <th colspan="4">Total Pending<br>Kanan</th>
        <th colspan="2">Aktif-2+<br>Aktif-3</th>
        <th colspan="2">Pending</th>
        <th colspan="2">Aktif2+<br>Aktif3</th>
      </tr>  
      <tr>
        <th>Prev</th>
        <th>New</th>
        <th>Trx-2</th>
        <th>Total</th>
        <th>Prev</th>
        <th>Total</th>
        <th>Prev</th>
        <th>New</th>
        <th>Trx-2</th>
        <th>Total</th>
        <th>Prev</th>
        <th>Total</th>
        <th>L</th>
        <th>R</th>
        <th>L</th>
        <th>R</th>
      </tr>      
    </thead>
    
    
    <tbody id="content-bpv-ranking">
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
        url: '<?php echo url('load-bpv-ranking'); ?>',
        type: 'get',
        data: {
          page: page,
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
          $('#content-bpv-ranking').html(result);
          $("#div-loading").hide();
        }
      });
    }
    function create_pagination(page)
    {
      $.ajax({
        url: '<?php echo url('pagination-bpv-ranking'); ?>',
        type: 'get',
        data: {
          page : page,
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
    function generate_bpv()
    {
      $.ajax({                                      
        url: '<?php echo url('generate-bpv-ranking'); ?>',
        type: 'get',
        data: {
          toperiodebefore: ($('#from').datepicker('getDate').getTime()/1000),
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
          var data = jQuery.parseJSON(result);
          $("#alert").show();
          $("#alert").html(data.message);
          if(data.type=='success')
          {
            $("#alert").addClass('alert-success');
            $("#alert").removeClass('alert-danger');
            refresh_page(1);
            create_pagination(1);
          }
          else if(data.type=='error')
          {
            $("#alert").addClass('alert-danger');
            $("#alert").removeClass('alert-success');
          }
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
      $('#button-generate').click(function(e){
        e.preventDefault();
        generate_bpv();
      });
    });
  </script>		
  
@endsection
