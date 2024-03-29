function validateRn(rn)
{
	var modulo;

	var millenaire;
	var annee;
	var mois;
	var jour;
	var sexe;
	var verif;
	
	if (rn.length==11)
	{
		annee = rn.substr(0, 2);
		mois = rn.substr(2, 2);
		jour = rn.substr(4, 2);
		sexe = rn.substr(6, 3);

		modulo = annee + mois + jour + sexe;
		verif = rn.substr(9, 2);

		if(97 - (modulo % 97) != verif)
		{
			return validateRn('2' + rn);
		}
		else
		{
			return true;
		}
	}
	else if(rn.length==12)
	{
		millenaire = rn.charAt(0);
		annee = rn.substr(1, 2);
		mois = rn.substr(3, 2);
		jour = rn.substr(5, 2);
		sexe = rn.substr(7, 3);

		if (millenaire == '2')
		{
			modulo = '2' + annee + mois + jour + sexe;
		}
		else
		{
			modulo = annee + mois + jour + sexe;
		}
		verif = rn.substr(10, 2);

		if(97 - (modulo % 97) != verif)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	else
	{
		return false;
	}
}

$(document).ready(function() {
	$.browser.msie && $.browser.version < 8 && $("input,select,textarea").live("focus", function() {
		$(this).removeClass("blur").addClass("focus"); 
	}).live("blur", function() { 
		$(this).removeClass("focus").addClass("blur"); 
	});
	
	/* DATEPICKER */
	$('.datepicker').datepicker({
			dateFormat: 'dd/mm/yy',
			dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
			dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
			dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
			firstDay: 1,
			monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
			monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Dec'],
			nextText: 'Suivant',
			prevText: 'Précédent',
			closeText: 'Fermer',
			currentText: 'Aujourd\'hui',
			showWeek: true,
			changeYear: true,
			yearRange: '1900:2099',
			weekHeader: 'Sem',
			showAnim: 'scale',
			showOn: 'button',
			buttonImage: "includes/images/calendar.png",
			buttonText: 'Choisissez votre date',
			buttonImageOnly: true,
			showButtonPanel: true
	});
	
	$('#loading').dialog({
		title: " Chargement en cours ...",
		height: 62,
		width: 208,
		closeText: "hide",
		resizable: false,
		draggable: false,
		modal: true,
		autoOpen: false
	});
});