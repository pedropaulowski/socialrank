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
                $('#redirect').attr("src",'perfil.php?nick='+json.nick);
                
                if(json.media > 1 && json.media < 1.5){
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

			}, 
			error:function() {
				$("#erro").removeClass("hidden");
			}
		});
	});
	
});
$(function(){
	$('#description').bind('submit', function(e){
		e.preventDefault();

		var txt = $(this).serialize();

		//enviar para o arquivo php

		$.ajax({
			type: 'POST',
			url: 'editar-descricao.php',
			data: txt,
			dataType:'json',
			success:function(json){
                $("#description").addClass("hidden");
                $("#descricaoatt").html(json.descricao);
                $("#textarea_description").val("");
                
			}, 
			error:function() {
				$("#erro").removeClass("hidden");
			}
		});
	});
	
});


function abrirForm() {
    let formulario = document.querySelector("#form-foto");
    let xbutton = document.querySelector("#fecharfoto");

    formulario.removeAttribute("class", "hidden");
    formulario.setAttribute("display", "block");

    xbutton.setAttribute("display", "block");
    xbutton.removeAttribute("class", "hidden");

}

function fecharForm() {
    let formulario = document.querySelector("#form-foto");
    let xbutton = document.querySelector("#fecharfoto");

    formulario.removeAttribute("display", "block");
    formulario.setAttribute("class", "hidden");

    xbutton.removeAttribute("display", "block");
    xbutton.setAttribute("class", "hidden");
}

function editDescription() {
    let formulario = document.querySelector("#description");
    let xbutton = document.querySelector("#fechar");

    formulario.setAttribute("display", "block");
    formulario.removeAttribute("class", "hidden");

    xbutton.setAttribute("display", "block");
    xbutton.removeAttribute("class", "hidden");
}

function fecharFormDescription() {
    let formulario = document.querySelector("#description");
    let xbutton = document.querySelector("#fechar");
    
    formulario.removeAttribute("display", "block");
    formulario.setAttribute("class", "hidden");

    xbutton.removeAttribute("display", "block");
    xbutton.setAttribute("class", "hidden");
}