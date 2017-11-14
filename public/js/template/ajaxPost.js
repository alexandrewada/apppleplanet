$(function(){

	

	$("#ajaxForm").submit(function(e){

		if(confirm("Tem certeza que deseja realizar está ação?") == false) {
			return false;
		}

		e.preventDefault();

		var url 	= $(this).attr('action');
		var dados	= $(this).serialize();

		$("#retorno").hide();

		$("#ajaxForm button[type='submit']").hide();
		$("body").css('opacity','0.1');

		$.post(url,dados,function(e){

		}).done(function(e){
			if(e.erro == true) {
				$("#retorno").removeClass('alert-success').addClass('alert-danger').html(e.msg).hide().show();
			} else {
				$("#retorno").removeClass('alert-danger').addClass('alert-success').html(e.msg).hide().show();
				$("#ajaxForm").trigger('reset');

			}

		$("#ajaxForm button[type='submit']").show();
		$("body").css('opacity','');
	
		}).fail(function(e){
			alert('Ocorreu um erro, contate o desenvolvedor.' + e);
			$("#ajaxForm button[type='submit']").show();
		});



	});

});