$(function(){
	$('#form').bind('submit', function(e){
		e.preventDefault();

		var txt = $(this).serialize();

		//enviar para o arquivo php

		$.ajax({
			type: 'GET',
			url: 'buscar.php',
			data: txt,
			dataType:'json',
			success:function(json){
                $("#perfil").removeClass("hidden");
                $('#nome').html(json.nome);
                $('#img').attr("src",json.img_url);
                $('#media').html(json.media);
                $('#avaliacoes').html(json.avaliacoes);
                $('#redirect').attr("href",'perfil.php?nick='+json.nick+'&&pagina=0');
                

                
                if(json.media >= 1 && json.media < 1.5){
                    $('#estrelas').attr("src","./imagens/1star.png");
                } else if(json.media >= 1.5 && json.media < 2.0){
                    $('#estrelas').attr("src","./imagens/1-5stars.png");
                } else if(json.media >=2 && json.media < 2.5){
                    $('#estrelas').attr("src","./imagens/2stars.png");
                }   else if(json.media >= 2.5 && json.media < 3.0){
                    $('#estrelas').attr("src","./imagens/2-5stars.png");
                }  else if(json.media >= 3.0 && json.media < 3.5){
                    $('#estrelas').attr("src","./imagens/3stars.png");
                } else if(json.media >= 3.5 && json.media < 4.0){
                    $('#estrelas').attr("src","./imagens/3-5stars.png");
                } else if(json.media >= 4.0 && json.media < 4.5){
                    $('#estrelas').attr("src","./imagens/4stars.png");
                } else if(json.media >= 4.5 && json.media < 5){
                    $('#estrelas').attr("src","./imagens/4-5stars.png");
                } else if(json.media == 5){
                    $('#estrelas').attr("src","./imagens/5stars.png");
                }
                $("#erro").addClass("hidden");

			}, 
			error:function() {
                $("#erro").removeClass("hidden");
                $("#perfil").addClass("hidden");
			}
		});
	});
	
});
