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
			$.each(json, function(i, item) {
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
						feed.innerHTML = qtd + 1
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
						feed.innerHTML = qtd + 1
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
		}, 1500);

	})
}

function carre(tipo) {
    carregarComentarios(tipo)
	curtidas()
	notificacoes()

}

function carregarComentarios(tipo) {
    var txt = 'nick='+document.querySelector('#nick').innerHTML+'&&tipo='+tipo;
    //enviar para o arquivo php
    $.ajax({
        type: 'GET',
        url: 'coment.php',
        data: txt,
        dataType:'json',
        success:function(json){
            $.each(json, function(i, item) {
                var comentario = json[i].comentario
                var	hora = json[i].hora;
                $("#comentarios").append('<div class="coments bg-white coments-profile text-black mg-t10 mg-b10 word-break-break"><p>'+comentario+'</p><p class="coments-hora">'+hora+'</p> </div>');

            });
        }, 
    });

}