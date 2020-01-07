$(function(){
    $('#follow').on('change', "input:checkbox", function(){
        $('#follow').submit();
    });
});



$(function(){
	$('#follow').submit(function(e){
        e.preventDefault();

        var txt = $(this).serialize();
        console.log(txt);
        
        //enviar para o arquivo php
        
        $.ajax({
            type: 'GET',
            url: 'seguir.php',
            data: txt,
            dataType:'json',
            success:function(json){
                console.log(txt);
            }, 
            error:function() {
                console.log(txt);
            }
        });
	});
	
});
