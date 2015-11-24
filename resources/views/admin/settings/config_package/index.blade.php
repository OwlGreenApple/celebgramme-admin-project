@extends('layout.main')

@section('content')
  <div class="page-header">
    <h1>Config Packages</h1>
  </div>  
  <div class="cover-input-group">
    <div class="input-group">
      <a class="btn btn-primary" href="{{url('config-package/create', $parameters = [], $secure = null)}}" role="button">Add</a>
    </div>  
  </div>  
  
  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
  <table class="table table-bordered">  
    <thead>
      <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Value</th>
        <th>Bonus PV</th>
        <th>Type</th>
        <th>Value per month</th>
        <th>Showed</th>
        <th></th>
      </tr>
    </thead>
    
    
    <tbody id="content-config-package">
    </tbody>
    
  </table>  
  
  <nav>
    <ul class="pagination" id="pagination">
    </ul>
  </nav>  
  
  <script>
    function refresh_page(page)
    {
      $.ajax({                                      
        url: '<?php echo url('load-config-package'); ?>',
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
          $('#content-config-package').html(result);
          $("#div-loading").hide();
        }
      });
    }
    function create_pagination()
    {
      $.ajax({                                      
        url: '<?php echo url('pagination-config-package'); ?>',
        type: 'get',
        data: {
          from: ''
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
          
          $("#div-loading").hide();
        }
      });
    }
    $(document).ready(function(){
      $("#alert").hide();
      refresh_page(1);
      create_pagination();
      <?php if ($message<>'') { ?>
        $("#alert").show();
        $("#alert").html("<?php echo $message; ?>");
      <?php } if($type=="insert"){ ?>
        $("#alert").addClass('alert-success');
        $("#alert").removeClass('alert-danger');
      <?php } if($type=="delete"){ ?>
        $("#alert").addClass('alert-danger');
        $("#alert").removeClass('alert-success');
      <?php } ?>
    });
  </script>		
  
@endsection
