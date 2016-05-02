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
    <h1>Blast Email</h1>
  </div>  
  <p>	
	</p>
  
  <div class="alert alert-danger" id="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
  </div>  

  <div class="cover-input-group">

		<div class="input-group">
			Subject
    </div>  
    <div class="row">
			<div class="col-md-10">
				<input type="text" value="" class="form-control" id="text-subject">
			</div>  
    </div>  
  </div>  
  <div class="cover-input-group">
		<textarea name="editor1" id="editor1" rows="10" cols="80">
				{{$content}}
		</textarea>
		<script>
				// Replace the <textarea id="editor1"> with a CKEditor
				// instance, using default configuration.
				CKEDITOR.replace( 'editor1' );
		</script>	
	</div>  
	<br>
  <div class="cover-input-group">
    <div class="input-group fl">
      <input type="button" value="Send All" id="button-save" data-loading-text="Loading..." class="btn btn-primary"> 
    </div>  
    <div class="none"></div>
  </div>
  
  <script>
    $(document).ready(function(){
      $("#alert").hide();
			
      $('#button-save').click(function(e){
        e.preventDefault();
        $.ajax({
          url: '<?php echo url('send-blast-email'); ?>',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: {
						content : CKEDITOR.instances.editor1.getData(),
						subject : $("#text-subject").val(),
					},
          beforeSend: function()
          {
            $("#div-loading").show();
          },
          dataType: 'text',
          success: function(result)
          {
            // var data = jQuery.parseJSON(result);
            $("#div-loading").hide();
          }
        });
      });

			
			
    });
  </script>		
  
@endsection
