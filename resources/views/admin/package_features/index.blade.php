@extends('layout.main')

@section('content')
  <div class="page-header">
    <h1>Daftar Package Feature</h1>
  </div>  

  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="text" id="search-text" class="form-control" placeholder="Name/Value" value="{{ $search }}"> 
    </div>
    <div class="input-group fl">
      <input type="button" name="search" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>
	<div class="input-group fl">
		<a class="btn btn-success" href="{{url('add-package-feature', $parameters = [], $secure = null)}}"><i class="glyphicon glyphicon-plus"></i> Add</a>
	</div>
    <?php if ($user->level==1) { ?>
      <div class="btn-group" role="group" aria-label="...">
        <button type="button" id="deleteLabel" class="btn">Delete</button>
        <button type="button" class="btn" id="deleteOn" onclick="toggleDelete();">ON</button>
        <button type="button" class="btn btn-primary" id="deleteOff" onclick="toggleDelete();">OFF</button>
      </div>
    <?php } ?>
    <div class="none"></div>
</div>
  
  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
  <table class="table table-hover">  
    <thead>
      <tr>
        <th class="col-md-1">No.</th>
        <th>Feature</th>
        <th>Value</th>
        <th>Package</th>
        <?php if ($user->level==1) { ?>
          <th colspan='2' align="left">Opsi</th>
        <?php } ?>
      </tr>      
    </thead>
    
    
    <tbody id="content-list">
    </tbody>
    
  </table>  
  <script>
    function refresh_page(page)
    {
      
      var documentUrl = window.location.search.substring('search');
      $.ajax({
        url: '<?php echo url('load-list-package-features'); ?>',
        type: 'get',
        data: {
          search : $("#search-text").val(),
          page: page,
        },
        beforeSend: function()
        {
          $("#div-loading").show();
        },
        dataType: 'text',
        success: function(result)
        {
          $('#content-list').html(result);
          $("#div-loading").hide();
        }
      });
    }
    
        $(document).ready(function(){
          var page = getParameterByName('page');
          if(page == 'undefined'){
            var page = <?php echo $page = (isset($page))?$page:1; ?>;    
          }
          
          $("#alert").hide();
          refresh_page(page);
          $('#button-search').click(function(e){
            e.preventDefault();
            refresh_page(1);
          });

        });
		
      function toggleDelete(){
          $('#deleteOn').toggleClass('btn-success');
          $('#deleteOff').toggleClass('btn-primary');
          $('#deleteLabel').toggleClass('btn-danger');
          var attr = $('.deleteButton').attr('disabled');
          $('.deleteButton').attr("disabled", "disabled");  
          if (typeof attr !== typeof undefined && attr !== false) {
              $('.deleteButton').removeAttr("disabled");    
          }
      }
      
      function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "undefined" : decodeURIComponent(results[1].replace(/\+/g, " "));
      }
  </script>
  
@endsection