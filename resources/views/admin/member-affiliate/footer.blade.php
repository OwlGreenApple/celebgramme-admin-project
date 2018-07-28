@extends('layout.main')

@section('content')
<style>
	.wrap{
		// white-space: pre-wrap;      /* CSS3 */   
		// white-space: -moz-pre-wrap; /* Firefox */    
		// white-space: -pre-wrap;     /* Opera <7 */   
		// white-space: -o-pre-wrap;   /* Opera 7 */    
		word-wrap: break-word;      /* IE */		
		width:350px;
	}
</style>


	

  <div class="page-header">
    <h1>Footer ads</h1>
  </div>  
  <p>	
	</p>
  
  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  


	<textarea name="editor1" id="editor1" rows="10" cols="80">
			{{$content}}
	</textarea>
	<script>
			// Replace the <textarea id="editor1"> with a CKEditor
			// instance, using default configuration.
			CKEDITOR.replace( 'editor1' );
	</script>	
	
  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="button" value="Save" id="button-save" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
    <div class="none"></div>
  </div>
  
  <script>
    $(document).ready(function(){
      $("#alert").hide();
			
      $('#button-save').click(function(e){
        e.preventDefault();
        $.ajax({
          url: '<?php echo url('save-footer-ads'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: {
						content : CKEDITOR.instances.editor1.getData()
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
            if(data.type=='success') {
              $("#alert").addClass("alert-success");
              $("#alert").removeClass("alert-danger");
            } else if (data.type=='error') {
              $("#alert").addClass("alert-danger");
              $("#alert").removeClass("alert-success");
            }
            $("#div-loading").hide();
          }
        });
      });

			
			
    });
  </script>		
  
@endsection
