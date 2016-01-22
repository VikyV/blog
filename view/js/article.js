$(document).ready(function()
	{	
		
		$('.icones-smile').raty({
			path:"view/images/img",
			scoreName: "note",
			number: 10,
			
			
			
		});
		$('.scorenote').each(function()
			{
				$(this).raty({
				path:"view/images/img",
				readOnly: true,
				number: 10,
				start:$(this).attr("data-note")
				});

			});
	
	//$('#butonsubmit').on('click','submit');

	$('#formCom').on('submit', function(event){
    	event.preventDefault(); //stopper le comportement par défaut du formulaire
    	var dataForm = $(this).serialize();
        console.log(dataForm);

        $.ajax({
        
        	type:"POST",
            data: dataForm,
            //optionnel
            url:window.location.href,
            dataType: 'json'// Permet de spécifier que l'on récupère des informations au format json
            }).done(function(data){//data représente les données retournées par la requête en ajax
            	console.log(data);
            	console.log(data.sucess);
            	//<P CLASS EST LÀ POUR AVOIR LA MISIE EN PAGE BOOTSTRAP
            $('#formCom').parent().before('<p class="alert alert-success">'+ data.sucess +'</p>');	
            $('.media').before(data.commentaire);
            });

    });




});