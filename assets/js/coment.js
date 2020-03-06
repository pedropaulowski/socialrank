$(function(){
	$('#coment').bind('submit', function(e){
		e.preventDefault();
        var txt = $(this).serialize();
		//enviar para o arquivo php

		$.ajax({
			type: 'GET',
			url: 'coment.php',
			data: txt+'&&tipo=maior',
			dataType:'json',
			success:function(json){
				console.log(json);
				$.each(json, function(i, item) {
					var comentario = json[i].comentario
					var	hora = json[i].hora;
					$("#comentarios").append('<div class="coments bg-not coments-profile text-black mg-t10 mg-b10 word-break-break"><p>'+comentario+'</p><p class="coments-hora">'+hora+'</p> </div>');

				});
			}, 
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




