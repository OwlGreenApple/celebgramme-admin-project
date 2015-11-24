@extends('layout.main')

@section('content')
  <div class="page-header">
    <h1>Daftar Category</h1>
  </div>  

  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="text" id="search-text" class="form-control" placeholder="kategori/deskripsi" value="{{ $search }}"> 
    </div>
    <div class="input-group fl">
      <input type="button" name="search" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>
	<div class="input-group fl">
		<a class="btn btn-success" href="{{url('add-product-category', $parameters = [], $secure = null)}}"><i class="glyphicon glyphicon-plus"></i> Add</a>
	</div>
    <?php //if ($user->level==1) { ?>
      <div class="btn-group" role="group" aria-label="...">
        <button type="button" id="deleteLabel" class="btn">Delete</button>
        <button type="button" class="btn" id="deleteOn" onclick="toggleDelete();">ON</button>
        <button type="button" class="btn btn-primary" id="deleteOff" onclick="toggleDelete();">OFF</button>
      </div>
    <?php //} ?>
    <div class="none"></div>
</div>
  
  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
  <table class="table table-hover">  
    <thead>
      <tr>
        <th class="col-md-1">No.</th>
        <th>Kategori</th>
        <th>Deskriptsi</th>
        <th>Type</th>
        <th>Image</th>
        <?php //if ($user->level==1) { ?>
          <th align="left">Opsi</th>
        <?php //} ?>
      </tr>      
    </thead>
    
    
    <tbody id="content-list">
    </tbody>
    
  </table>  
  <script>
    $(document).ready(function(){
		prepareData('<?php echo url('load-list-product-categories'); ?>');
    });
		
  </script>
  
@endsection