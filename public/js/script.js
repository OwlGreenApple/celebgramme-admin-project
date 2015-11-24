	function refresh_page(page,url){
		var documentUrl = window.location.search.substring('search');
		$.ajax({
			url: url,
			type: 'get',
			data: {
				search : $("#search-text").val(),
				page: page,
			},
			beforeSend: function(){
				//$("#div-loading").show();
			},
			dataType: 'text',
			success: function(result){
				$('#content-list').html(result);
				//$("#div-loading").hide();
			}
		});
    }
	
	function prepareData(url){
         var page = getParameterByName('page');
         if(page == 'undefined'){
			var page = 1;
         }
        $("#alert").hide();
        refresh_page(page,url);
        $('#button-search').click(function(e){
			e.preventDefault();
			refresh_page(1,url);
		});
    };
		
	function showHiddenContent(x){
		$('#'+x).toggleClass('display-none');
		return false;
	}
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
	  
	  function getImage(id,url){
		if($('#image-tr-'+id).hasClass('myhide')){
			$.ajax({
				url: url,
				type: 'get',
				data: {
					id: id,
				},
				beforeSend: function(){
					//$("#div-loading").show();
				},
				dataType: 'text',
				success: function(result){
					$('#image-list-'+id).html(result);
					$('#image-tr-'+id).removeClass('myhide');
					//$("#div-loading").hide();
				}
			});
		}else{
			$('#image-tr-'+id).addClass('myhide');
		}
		
		return false;
    }