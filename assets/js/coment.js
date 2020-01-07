$(function(){
	$('#coment').bind('submit', function(e){
		e.preventDefault();
		var comentario = $("#comentario-now").val();
        var txt = $(this).serialize();
		//enviar para o arquivo php

		$.ajax({
			type: 'GET',
			url: 'coment.php',
			data: txt,
		
			success:function(data){
			$("#live").removeClass("hidden");
			$("#texto-coment").html(comentario);
			$("#hora-coment").html("Agora");
			$("#comentario-now").val() = '';
			}, 
			error:function() {
             alert("ERRO");
            }
		});
	});
	
});

$(function(){
	$('#follow').on('change', function(e){
		e.preventDefault();

        var id_dad = $("#id_dad").val();
		var id_son = $("#id_son").val();
		var txt = "id_dad="+id_dad+"&&id_son="+id_son;
		//enviar para o arquivo php

		$.ajax({
			type: 'GET',
			url: 'seguir.php',
			data: txt,
			dataType:'json',

			success:function(json){
				$("#segs").html(json.total);	
			}, 
			error:function() {
             alert("ERRO");
            }
		});
	});
	
});




