$(function(){
	$('#nota1').on('click', function(e){
		e.preventDefault();
		$('#nota1').addClass("bg-yellow");
		$('#nota5').removeClass("bg-yellow");
		$('#nota4').removeClass("bg-yellow");
		$('#nota3').removeClass("bg-yellow");
		$('#nota2').removeClass("bg-yellow");
		var nota = 1;
		var nick = document.querySelector("#nick").text;
		var txt = "nick="+nick+"&&nota="+nota;
		
		//enviar para o arquivo php

		$.ajax({
			type: 'GET',
			url: 'votar.php',
			data: txt,
			dataType:'json',

			success:function(json){
				$("#media").html(json.media);
				$("#notas1").html(json.nota1);
				$("#notas2").html(json.nota2);
				$("#notas3").html(json.nota3);
				$("#notas4").html(json.nota4);
				$("#notas5").html(json.nota5);
			}, 
			error:function() {
                alert("Você não está cadastrado");

            }
		});
	});
	
});
$(function(){
	$('#nota2').on('click', function(e){
		e.preventDefault();
		$('#nota1').addClass("bg-yellow");
		$('#nota2').addClass("bg-yellow");
		$('#nota5').removeClass("bg-yellow");
		$('#nota4').removeClass("bg-yellow");
		$('#nota3').removeClass("bg-yellow");

		var nota = 2;
		var nick = document.querySelector("#nick").text;
		var txt = "nick="+nick+"&&nota="+nota;
		
		//enviar para o arquivo php

		$.ajax({
			type: 'GET',
			url: 'votar.php',
			data: txt,
			dataType:'json',

			success:function(json){
				$("#media").html(json.media);
				$("#notas1").html(json.nota1);
				$("#notas2").html(json.nota2);
				$("#notas3").html(json.nota3);
				$("#notas4").html(json.nota4);
				$("#notas5").html(json.nota5);
			}, 
			error:function() {
                alert("Você não está cadastrado");
            }
		});
	});
	
});
$(function(){
	$('#nota3').on('click', function(e){
		e.preventDefault();
		$('#nota3').addClass("bg-yellow");
		$('#nota1').addClass("bg-yellow");
		$('#nota2').addClass("bg-yellow");
		$('#nota5').removeClass("bg-yellow");
		$('#nota4').removeClass("bg-yellow");

		var nota = 3;
		var nick = document.querySelector("#nick").text;
		var txt = "nick="+nick+"&&nota="+nota;
		
		//enviar para o arquivo php

		$.ajax({
			type: 'GET',
			url: 'votar.php',
			data: txt,
			dataType:'json',

			success:function(json){
				$("#media").html(json.media);
				$("#notas1").html(json.nota1);
				$("#notas2").html(json.nota2);
				$("#notas3").html(json.nota3);
				$("#notas4").html(json.nota4);
				$("#notas5").html(json.nota5);
			}, 
			error:function() {
                alert("Você não está cadastrado");
            
            }
		});
	});
	
});
$(function(){
	$('#nota4').on('click', function(e){
		e.preventDefault();
		$('#nota4').addClass("bg-yellow");
		$('#nota3').addClass("bg-yellow");
		$('#nota1').addClass("bg-yellow");
		$('#nota2').addClass("bg-yellow");
		$('#nota5').removeClass("bg-yellow");

		var nota = 4;
		var nick = document.querySelector("#nick").text;
		var txt = "nick="+nick+"&&nota="+nota;
		
		//enviar para o arquivo php

		$.ajax({
			type: 'GET',
			url: 'votar.php',
			data: txt,
			dataType:'json',

			success:function(json){
				$("#media").html(json.media);
				$("#notas1").html(json.nota1);
				$("#notas2").html(json.nota2);
				$("#notas3").html(json.nota3);
				$("#notas4").html(json.nota4);
				$("#notas5").html(json.nota5);
			}, 
			error:function() {
                alert("Você não está cadastrado");            
            }
		});
	});
	
});
$(function(){
	$('#nota5').on('click', function(e){
		e.preventDefault();
		$('#nota5').addClass("bg-yellow");
		$('#nota4').addClass("bg-yellow");
		$('#nota3').addClass("bg-yellow");
		$('#nota2').addClass("bg-yellow");
		$('#nota1').addClass("bg-yellow");

		var nota = 5;
		var nick = document.querySelector("#nick").text;
		var txt = "nick="+nick+"&&nota="+nota;
		
		//enviar para o arquivo php

		$.ajax({
			type: 'GET',
			url: 'votar.php',
			data: txt,
			dataType:'json',

			success:function(json){
				$("#media").html(json.media);
				$("#notas1").html(json.nota1);
				$("#notas2").html(json.nota2);
				$("#notas3").html(json.nota3);
				$("#notas4").html(json.nota4);
				$("#notas5").html(json.nota5);

			}, 
			error:function() {
                alert("Você não está cadastrado");
                
            }
		});
	});
	
});
