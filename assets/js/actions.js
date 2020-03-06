$(function(){
	$('#description').bind('submit', function(e){
		e.preventDefault()

		var txt = $(this).serialize()
		//enviar para o arquivo php

		$.ajax({
			type: 'POST',
			url: 'postar.php',
			data: txt,
			dataType:'json',
			success:function(json){
				$("#textarea_post").val("")
			}, 
			error:function() {
			}
		});

	});
	
});

function atualizar() {

	var nickname = document.querySelector('#nick').value
	var nick = 'nick='+nickname

	$.ajax({
		type: 'POST',
		url: 'api-posts.php',
		data: nick,
		dataType:'json',

		
		beforeSend : function(){
			
		}	
		
	})
		.done(function(json){

				$.each(json, function(i, item) {
					var texto = json[i].texto
					var nickname = json[i].nick
					var nick = 'nick='+json[i].nick
					var hora = ''

					for(let j = 5; j < 19; j++){
						
						hora+= json[i].hora[j]
					}

					var id_post = json[i].id_post
					var curtidas = json[i].curtidas
					var post_id = json[i].id_post
					$.ajax({
						type: 'GET',
						url: 'api-foto.php',
						data: nick,
						dataType:'json',
						success:function(json){
							let img_url = json.img_url;
							$("#posts-content").prepend('<div id="'+id_post+'"class="border2-white flex-column post mg-t5 mg-b50"><div class="flex" ><div class="img-circle"><img src="'+img_url+'" class="img" id="img-profile-post"/></div><div class="mg-t30 mg-l30"><a class="text-white"href="perfil.php?nick='+nickname+'&&pagina=0"><b>@'+nickname+'</b></a></div></div><div class="text-center mg-b10"><p class="text-white">'+texto+'</p></div><div class="flex justify-content-around mg-b10"><button onclick="curtir('+id_post+')"class="curtir refresh" id="'+id_post+'"><div><i id="coracao_post'+id_post+'"class="fa fa-heart" style="font-size:28px;color:white"></i></div><div id="curtidas_post'+id_post+'" style="color:white">'+curtidas+'</div></button><div><p class="text-white font-12">'+hora+'</p></div></div></div>')
							id_post = "comentariotopost"+id_post
							let toQuerySelector = "document.querySelector('#"+id_post+"').value"
							img_url = document.querySelector("#img-profile-to-post").src
							$('#'+post_id+'').append('<div class="flex justify-content-center" id="div-to-coment"><div class="img-circle-coment"><img src="'+img_url+'" class="img-coment" id="img-profile-coment"/></div><form method="GET" id="form-coment"><textarea id="'+id_post+'" class="coment text-black" type="text" name="nick" placeholder="Comentário..."></textarea></form><button class="submit mg-t10" onclick="comentar('+post_id+','+toQuerySelector+')" ></button></div>')
						}, 
						error:function() {
							$("#erro").removeClass("hidden");
						}
					});
				});

                setTimeout(function(){
                    atualizar()
                }, 1000);
			
			
		})

        .fail(function(json){
            setTimeout(function(){
                atualizar()
            }, 1000);

		})




}

function curtir(id_post){
		var id_post = id_post
		var txt = "id_post="+id_post
		var curtidas_post = "#curtidas_post"+id_post
		var coracao_post = "#coracao_post"+id_post

		//enviar para o arquivo php

		$.ajax({
			type: 'POST',
			url: 'curtir.php',
			data: txt,
			dataType:'json',

			success:function(json){
				$(curtidas_post).html(json.qtd_curtidas);
				if($(coracao_post).css('color') == "rgb(255, 255, 255)")
					$(coracao_post).css('color', 'red');
				else 
					$(coracao_post).css('color', 'white')
			}, 
			error:function() {
				alert("Você não está cadastrado")
			}
		});

}

function comentar(id_post, comentario) {
	var txt = 'id_post='+id_post+'&comentario='+comentario
	$.ajax({
		type: 'GET',
		url: 'coment.php',
		data: txt,
		
		success:function(){
			var id = '#comentariotopost'+id_post
			document.querySelector(''+id+'').value = 'SUCESSO!'
		}, 
		error:function() {
		}
	});

}

function notificacoes() {

	var nickname = document.querySelector('#nick').value
	var nick = 'nick='+nickname
	
	$.ajax({
		type: 'POST',
		url: 'api-comentarios.php',
		data: nick,
		dataType:'json',

		
		beforeSend : function(){
			
		}	
		
	})
	.done(function(json){
			var j = 0

			$.each(json, function(i, item) {
				j++;
				var texto = json[i].comentario
				var hora = json[i].hora
				var id_remetente = "id="+json[i].id_remetente;
				$.ajax({
					type: 'GET',
					url: 'api-nicks.php',
					data: id_remetente,
					dataType:'json',
					success:function(json){
						var nick = json.nick

						//console.log(nick+" cometou em seu post: "+ texto+" às "+hora)
						var qtd = parseInt(document.querySelector("#notifications").innerHTML)
						var feed = document.querySelector("#notifications")
						feed.innerHTML = j+qtd
						$('.aba-notifications').prepend('<div class="coments bg-not coments-profile text-black mg-t10 mg-b10 word-break-break"><p>'+nick+' comentou: '+texto+'</p><p class="coments-hora">'+hora+'</p></div>')
					}, 
				});
			});

	
			setTimeout(function(){
				notificacoes()
			}, 1000);
		
		
	})

	.fail(function(json){
		setTimeout(function(){
			notificacoes()
		}, 1000);

	})


}

function showNotifications() {
	var aba = document.querySelector(".aba-notifications")
	
	if(aba.style.display == "none") 
		aba.style.display = "block"
	 else 
		aba.style.display = "none"
	
}


function curtidas() {

	var nickname = document.querySelector('#nick').value
	var nick = 'nick='+nickname
	
	$.ajax({
		type: 'POST',
		url: 'api-curtidas.php',
		data: nick,
		dataType:'json',

		
		beforeSend : function(){
			
		}	
		
	})
	.done(function(json){
			var j = 0

			$.each(json, function(i, item) {
				j++;
				var hora = json[i].hora
				var id_remetente = "id="+json[i].id_user;
				$.ajax({
					type: 'GET',
					url: 'api-nicks.php',
					data: id_remetente,
					dataType:'json',
					success:function(json){
						var nick = json.nick
						var qtd = parseInt(document.querySelector("#notifications").innerHTML)
						var feed = document.querySelector("#notifications")
						feed.innerHTML = j+qtd
						$('.aba-notifications').prepend('<div class="coments bg-not coments-profile text-black mg-t10 mg-b10 word-break-break"><p>'+nick+' curtiu um post seu.</p><p class="coments-hora">'+hora+'</p></div>')
					}, 
				});
			});

			setTimeout(function(){
				curtidas()
			}, 1500);
		
		
	})

	.fail(function(json){
		setTimeout(function(){
			curtidas()
		}, 1000);

	})
}

function carre() {
	notificacoes()
	atualizar()
	curtidas()
}