$(function(){
	$('#positions').bind('submit', function(e){
		e.preventDefault();

		var txt = $(this).serialize();

		//enviar para o arquivo php

		$.ajax({
			type: 'GET',
			url: 'api-ranking.php',
			data: txt,
			dataType:'json',
			success:function(json){
                
			}, 
			error:function() {
			}
		});
	});
	
});

/*<div class="flex justify-content-center mg-t30 hidden" id="perfil">
<div class="flex justify-content-between">
    <div class="flex">
        <div class="img-circle" >
            <img id="img" src="./imagens/pedropaulo.jpg">
        </div>
    </div>
    <div class="flex flex-column mg-l30 border2-white width-stats ">
        <div>
            <a href="" id="redirect" class="text-white"><b id="nome"></b></a>
        </div>
        <div class="flex">
            <a class="text-white mg-t5" >Nota: <b id="media"></b></a>
            <a><img id="estrelas"/></a>
        </div>
        <div class="flex">
            <a class="text-white mg-t5">Avaliações: <b id="avaliacoes"></b></a>
        </div>
    </div>    
</div>
</div>*/