/**
  fonction pour afficher la liste des présentations
  par categorie.
  defini les styles css des elements et leurs effets.
*/
    $(".actionAdmin").click(function(e) {
        $(this).each(function() {
        // envoi de la requete
            e.preventDefault();
            idUser = $(this).attr('id');
            var action = $(this).attr('name');
            var text = $(this).html();
            var newText ='';

            if(action=='inversBan')
                 newText = (text == 'Bannir')? "Réhabiliter":"Bannir";
            if(action=='inversActiv')
                 newText = (text == 'Activer')? "Désactiver":"Activer";
            if(action=='inversAdmin')
                 newText = (text == 'Déchoir')? "Promouvoir":"Déchoir";
            
           $.ajax({
                method: "GET",
                url: "index.php?Usagers&action="+action+"&idUsager="+idUser,
                dataType:"html",
        // comportement en cas de success ou d'echec
              success:function(reponse) {
                $('#'+idUser+'[name='+action+']').html(newText);
              },
              error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
              }
            });

        });

    });

$(document).ready(function() {
    
    //Afficher profil d'usager
		$("#div_info_plus").append($("#info_plus"));
		
		$("#div_info_contact").append($("#info_contact"));
        
		$("#div_modif_profil").append($(".btn-modifier"));
		
		$("#div_messagerie").append($("#messagerie"));
		
		$("#div_action_admin").append($("#action_admin"));
       
		$(".menuProfil").append($("#div_action_admin"));
		
		$("#div_historique").append($("#historique"));
		
		$("#div_reservations").append($("#reservations"));
		
		$("#div_mes_appts").append($("#mes_appts"));
		
    //Action: Modifier le profil d'usager
	$(document).on('click', '.sauvegarder', function(e){
	e.preventDefault();
	var idUser = $(this).prev().val();
	
	var formulaire = $("#modifierProfil"+idUser).serialize();
	

	$.ajax({
		url: 'index.php?Usagers&action=modifierProfil&'+formulaire,
		method: "POST",		
		data: {
			jsonData: JSON.stringify({
				prenom : $('input[name="prenom"]').val(),
				nom : $('input[name="nom"]').val(),
				adresse : $('input[name="adresse"]').val(),
				telephone : $('input[name="telephone"]').val(),
				contact : $('#moyenComm option:selected').text(),
				paiement : $('#modePaiement option:selected').text()
			}) 
		},   
		success: function (data) {
			try {
				var output = JSON.parse(data);
				alert(output);
			} catch (e) {
				alert("Output is not valid JSON: " + data);
			}
		}, error: function (request, error) {
			alert("AJAX Call Error: " + error);
		}
});
			
	/*
	$.ajax({
		url: 'index.php?Usagers&action=modifierProfil', //ajouter des parametres
		// dataType: 'html',
		data: $("#modifierProfil"+idUser).serialize(),
		contentType: 'application/json',
		cashe: false,
		dataType: 'json',
		success: function(reponse) {	
		alert(reponse);
		
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
*/	
});
        
    });
