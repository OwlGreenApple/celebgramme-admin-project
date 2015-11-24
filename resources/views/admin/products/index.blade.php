@extends('layout.main')

@section('content')
  <div class="page-header">
    <h1>Daftar Produk</h1>
  </div>  

  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="text" id="search-text" class="form-control" placeholder="Product/price/condition/location/description" value="{{ $search }}"> 
    </div>
    <div class="input-group fl">
      <input type="button" name="search" value="Search" id="button-search" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>
	<div class="input-group fl">
		<a class="btn btn-success" href="{{url('add-product', $parameters = [], $secure = null)}}"><i class="glyphicon glyphicon-plus"></i> Add</a>
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
  <table class="table table-bordered">  
    <thead>
      <tr>
        <th class="width50">No.</th>
        <th>Product</th>
        <th>Price</th>
        <th>Condition</th>
        <th>Location</th>
        <th>Description</th>
        <th>Stock</th>
        <th>Weight</th>
        <th>Supplier</th>
        <th>Category</th>
        <th>View</th>
        <?php //if ($user->level==1) { ?>
          <th align="center">Opsi</th>
        <?php //} ?>
      </tr>      
    </thead>
    
    
    <tbody id="content-list">
    </tbody>
    
  </table>  
  <script>
        $(document).ready(function(){
			prepareData('<?php echo url('load-list-products'); ?>');
        });
  </script>
  
@endsection