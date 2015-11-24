@extends('layout.main')

@section('content')
  <div class="page-header">
    <h1>Config Packages</h1>
  </div>  
  
  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  
  
<?php 
  if ($method=="insert") { 
    echo Form::open(array('url' => url("config-package"), 'method' => 'post', 'route' => ['config-package.store'], 'class'=>'form-horizontal'));
  }
  if ($method=="update") { 
    echo Form::open(array('url' => url("config-package")."/".$data["id"], 'method' => 'put', 'route' => ['config-package.update'], 'class'=>'form-horizontal'));
  }
?>
  <div class="form-group">
    <label for="inputName" class="col-sm-2 control-label">Name </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputName" placeholder="" name="inputName" value="<?php if ($method=="update") { echo $data['name']; } ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="inputValue" class="col-sm-2 control-label">Value </label>
    <div class="col-sm-10">
      <input type="number" onkeypress="return isNumberKey(event)" class="form-control" id="inputValue" placeholder="" name="inputValue" value="<?php if ($method=="update") { echo $data['value']; } ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="inputBonusPV" class="col-sm-2 control-label">Bonus PV </label>
    <div class="col-sm-10">
      <input type="number" onkeypress="return isNumberKey(event)" class="form-control" id="inputBonusPV" placeholder="" name="inputBonusPV" value="<?php if ($method=="update") { echo $data['bonus_pv']; } ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="type" class="col-sm-2 control-label">Type </label>
    <div class="col-sm-10">
      <select class="form-control" id="type" name="inputType">
      <option value="tahunan" <?php if ($method=="update") { if ($data['type']=='tahunan') {echo "selected";}  } ?>>Tahunan</option>
      <option value="bulanan" <?php if ($method=="update") { if ($data['type']=='bulanan') {echo "selected";}  } ?>>Bulanan</option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="inputValuePermonth" class="col-sm-2 control-label">Value Per Month </label>
    <div class="col-sm-10">
      <input type="number" onkeypress="return isNumberKey(event)" class="form-control" id="inputValuePermonth" placeholder="" name="inputValuePermonth" value="<?php if ($method=="update") { echo $data['permonth_value']; } ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="inputValueShowed" class="col-sm-2 control-label">Showed </label>
    <div class="col-sm-10">
      <input type="checkbox" id="inputValueShowed" placeholder="" name="inputValueShowed" <?php if ($data['showed']) { echo "checked";} ?> >
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Submit</button>
    </div>
  </div>
</form>  
  
  
  
  <script>
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
    $(document).ready(function(){
      $("#alert").hide();
    });
  </script>		
  
@endsection
