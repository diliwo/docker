<style type="text/css">
	@IMPORT URL('includes/css/person.css');
</style>

<script type="text/javascript">
// Tous les flux sont ici
var tabFlux  = { 
	"1": { 
		"name": "flux_transaction25", "params":"&only_all=1", "all": "flux_transaction25_all", "show": <?php echo $_SESSION[$_config['application_name']]['droits']['t25']?"true":"false"; ?>, "msg": "", "type": "GET", "timeout": "20000", "allow": <?php echo $_SESSION[$_config['application_name']]['droits']['t25']?"true":"false"; ?>,
		"lang": { "fr": "Transaction 25", "en": "Transaction 25", "nl": "Transaction 25" }
	}, "2": {
		 "name": "flux_childbenefits", "show": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,  "msg": "  " ,"type": "GET", "timeout": "20000", "allow": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,
		"lang": { "fr": "Cadaf", "en": "Cadaf", "nl": "Cadaf" }
	}, "3": { 
		"name": "flux_cadnet", "show": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>, "msg": "", "type": "GET", "timeout": "20000", "allow": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,
		"lang": { "fr": "Cadnet", "en": "Cadnet", "nl": "Cadnet"}
	}, "4": { 
		"name": "flux_healthcare-insurance", "show": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,  "msg": "" ,"type": "GET", "timeout": "20000", "allow": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,
		"lang": { "fr": "Assurabilité", "en": "Assurabilité", "nl": "Assurabilité"}
	}, "5": { 
		"name": "flux_attestations", "show": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,  "msg" : "" ,"type": "GET", "timeout": "20000", "allow": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,
		"lang": { "fr": "Attestations", "en": "Attestations", "nl": "Attestations" }
	}, "6": {
		 "name": "flux_unemployment_data", "show": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,  "msg": "" ,"type": "GET", "timeout": "20000", "allow": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,
		"lang": { "fr": "ONEM", "en": "ONEM", "nl" : "ONEM" }
	}, "7": { 
		"name": "flux_self_employed","show": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>, "msg": "" ,"type": "GET", "timeout": "20000", "allow": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,
		"lang": { "fr": "Indépendant", "en": "Indépendant", "nl": "Indépendant" }
	}, "8": {
		"name": "flux_handi","show": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,  "msg": "" ,"type": "GET", "timeout":"20000", "allow": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,
		"lang": { "fr": "DGPH", "en" : "DGPH", "nl": "DGPH" }
	}, "9": { 
		"name": "flux_integrations", "params":"", "show": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,  "msg": "" ,"type": "GET", "timeout": "20000", "allow": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,
		"lang": { "fr": "Intégrations", "en": "Intégrations", "nl": "Intégrations" }
	}, "10": { 
		"name": "flux_dolsis", "show": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,  "msg": "" ,"type": "GET", "timeout": "20000", "allow": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,
		"lang": { "fr": "Dimona", "en": "Dimona", "nl": "Dimona"  }
	}, "11": { 
		"name": "flux_taxi_as", "show": <?php echo $_SESSION[$_config['application_name']]['droits']['taxi_as']?"true":"false"; ?>,  "msg": "" ,"type": "GET", "timeout": "20000", "allow": <?php echo $_SESSION[$_config['application_name']]['droits']['taxi_as']?"true":"false"; ?>,
		"lang": { "fr": "Av. extrait de rôle", "en": "Av. extrait de rôle", "nl": "Av. extrait de rôle" }
	}, "12": { 
		"name": "flux_social_rate_investigation", "show": <?php echo $_SESSION[$_config['application_name']]['droits']['soctar']?"true":"false"; ?>, "msg": "", "type": "GET", "timeout": "20000", "allow": <?php echo $_SESSION[$_config['application_name']]['droits']['soctar']?"true":"false"; ?>,
		"lang": { "fr": "Tarif social", "en": "Tarif social", "nl": "Tarif social" }
	}, "13": { 
		"name": "flux_pension", "show": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,  "msg": "", "type": "GET", "timeout": "20000", "allow": <?php echo $_SESSION[$_config['application_name']]['droits']['fluxs_base']?"true":"false"; ?>,
		"lang": { "fr" : "Pension", "en" : "Pension", "nl": "Pension" }
	}, "14": { 
		"name": "flux_tous", "show": true,  "msg": "", "type": "GET", "timeout": "20000", "allow": true, 
		"desc": "Cette bouton permet d'afficher tous les flux et il doit être toujour à la fin. ",
		"lang": { "fr": "Tous", "en": "Tous", "nl": "Tous" }
	}

};

</script>

<div id="entete">
	<h1>Données B.C.S.S.</h1>
	<div id="personal_informations">
		<table width="100%">
			<tbody>
				<tr>
					<th>Numéro NISS (RN) : </th>
					<td><?php echo $personne->get('rn'); ?></td>
				</tr>

				<tr>
					<th>Nom : </th>
					<td id="td_last_name"><?php echo $personne->get('nom'); ?></td>
				</tr>

				<tr>
					<th>Prénom : </th>
					<td id="td_first_name"><?php echo $personne->get('prenom'); ?></td>
				</tr>

				<tr>
					<th>Date de naissance : </th>
					<td id="td_birthday"><?php echo $personne->get('date_naissance'); ?></td>
				</tr>

				<tr>
					<th>Sexe : </th>
					<td><?php echo $personne->get('sexe'); ?></td>
				</tr>

				<?php
				$adresse = $personne->get('adresse');
				if (!empty($adresse)): ?>
				<tr>
					<th>Adresse : </th>
					<td><?php echo $adresse; ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<div id="flux_bcss">

	<script type="text/javascript">
	 
	$( function() { 

		$.each(tabFlux, function (index) { 
			if( tabFlux[index].allow ) {
				$( "ul.tab_navig" ).append( "<li> <a href='#tab_" + tabFlux[index].name + "'>" + tabFlux[index].lang.fr + "</a> </li>" );

				if( index == 1 ) 
					$( "div.tab_container" ).append( "<div id='tab_" + tabFlux[index].all + "'> </div>" ); 
				
				$( "div.tab_container" ).append( "<div id='tab_" + tabFlux[index].name + "'> </div>" );
				
			}	
			
		});
		 
	});

	</script> 
	
	<ul class="tab_navig"> </ul>

	<div id="impression">
		<a class="print" href="#print" onclick="window.print();" title="Imprimer"><img src="includes/images/print.png"></a>
		<!-- <a class="pdf-old" href="pdf.php?action=flux_transaction25&rn=<?php echo $personne->get('rn'); ?>&only_all=1" title="Généner PDF"><img src="includes/images/pdf.png"></a>  -->
		<!-- <a class="pdf" href="#pdf" title="Générer un PDF"><img src="includes/images/pdf.png"></a> -->
	</div>

	<div class="tab_container"> </div>

</div>

<form id="pdf_form" method="post" action="pdf.php?rn=<?php echo $personne->get('rn'); ?>">
	<input type="hidden" id="html_content" name="html_content" value="">
</form>

<script type="text/javascript">

var Flux = {
	 
	name: "", /* Nome du flux  */	   
	count: 0, /* Comptoir */ 	 
	index: 1, /* Index de tableaux tabFlux */ 	 
	opt: null, /* Plusieurs réponses possible ( EACH="Clique sur le flux", ALL="Affiche tous", DEFAULT="Affiche premier flux") */

	tack: 0, /* Chaque flux comme comptoir */	
	buff: new Array(), /* Juste pour tester appi */	
	
	execute: function() {
		
		if( this.opt == "EACH" ) {

			if((tabFlux[1].name == tabFlux[1].all) && (this.name == "flux_transaction25")) {
				
				this.index = 1;
				this.checkBeforePrinting();
				return ;
				
			} 
			
			for( var i in tabFlux ) {

				if( tabFlux[i].name == this.name ) {
					this.index = i;
					this.checkBeforePrinting();
					break;
				}
			}
			
		} else {
			 
			this.index = 1;
			this.checkBeforePrinting();
			
		}	
		 	
	},
	
	executeAll: function() {
		
		this.index = ++this.tack;
		var len = 0; $.each(tabFlux, function (index) { len++; });
		
		if( this.tack < len ) {	 
			Flux.name = tabFlux[this.tack].name;
			return this.checkBeforePrinting();
			 
		} else {

			$("."+tabFlux[1].all).remove().prependTo($("#tab_flux_tous"));
					
			this.count=0;
			this.index=1;
			this.tack = 0;	
			 
		}

	},
	
	checkBeforePrinting: function() {

		if( !tabFlux[this.index].allow ) {
			if( Flux.opt == "ALL" && this.tack != 0 ) 
				Flux.executeAll(); 
			return;
		}
		
		if( tabFlux[this.index].show ) {  
			return this.printing();
			
		}  else {
			if( Flux.opt == "ALL" && this.tack != 0  )   
				Flux.executeAll(); 
		}

		$( "#tab_" + tabFlux[this.index].name ).html( "<h1>" + tabFlux[this.index].msg + "</h1>" );
		
	},
	
	addInBuffering: function() {
	
		if(this.name in this.buff ) { 
			return true;
			
		} else {
			this.buff[this.name] = this.name; 
			return false;
			
		}

	},

	btnTransactionShowHide: function() {
		
		if(Flux.opt == "ALL" ) { 
		
			if( tabFlux[this.index].name == tabFlux[1].name ) {
			 
				this.name = tabFlux[this.index].all;
				tabFlux[this.index].name = this.name;
				
				$("#tab_flux_transaction25").hide();
				$("#flux_transaction25").hide();
				$(".flux_transaction25").hide();

				$("#tab_flux_transaction25_all").hide(); 
				$("#flux_transaction25_all").show();
				$(".flux_transaction25_all").show();
				 
			} 

		} else if(Flux.opt == "EACH" ) { 
		
			if( tabFlux[this.index].name == tabFlux[1].name) {
			
	 			$("#tab_flux_transaction25").show();
	 			$("#flux_transaction25").show();
	 			$(".flux_transaction25").show();

	 			$("#tab_flux_transaction25_all").hide();
	 			$("#flux_transaction25_all").hide();
	 			$(".flux_transaction25_all").hide();
			
			}

		} 
		
	},
	
	printing: function() {

		this.btnTransactionShowHide();

		if( this.addInBuffering() ) { 
			if( Flux.opt == "ALL" && Flux.tack != 0  ) 
				Flux.executeAll();  
			return ; 
		}
	
		var tab         = "#tab_" + tabFlux[this.index].name;
		var name        = tabFlux[this.index].name;
		var timeout     = tabFlux[this.index].timeout;
		var form_method = tabFlux[this.index].type;
		
		$("#tab_flux_tous").append( "<div class='flux "+name+"'> </div>" );
		
		 setTimeout( function() { 
			 
			$.ajax({
				url: Flux.buildUri(),
				async:true, 
				timeout: timeout,
 				type: form_method,
 
 				beforeSend: function(xhr) {
 	 					
 					Flux.openDialog();	

 					if ($.trim($(tab).html())) {
 						Flux.closeDialog();
 					 
 						xhr.abort();
 						if( Flux.opt == "ALL" && Flux.tack != 0  ) Flux.executeAll(); 
 					} 
 				 
 	 			},
 	 			
				complete: function(xhr, status) {
					
					Flux.reloadFluxTransaction();
					
					if ($.trim($(tab).html()))
						Flux.closeDialog();
					if( Flux.opt == "ALL" && Flux.tack != 0  ) Flux.executeAll(); 
					 
				},

				success: function(val, status) {
				
					$(tab).html(val, status);
					$("#tab_flux_tous ."+name).append( val );
					qtipLoad();
					 
 				},

 				error: function() {
 	 				
 					Flux.closeDialog();
 					if( Flux.opt == "ALL" && Flux.tack != 0  ) Flux.executeAll(); 
					$(tab).html( "<h1> Problème avec le flux - " + name + "</h1>" );
 					 
				}
			
			});
			
		}, 1 );

	},

	buildUri: function() {

		var mark = window.location.href.toString().split(window.location.host)[1].split("&rn="); 
		
		var params = "";

		if( this.name == tabFlux[this.index].all ) {
			
			var params = tabFlux[this.index].params;	
			
			this.name = "flux_transaction25"; 
			tabFlux[this.index].name = "flux_transaction25";

		} 

		if(this.name == "flux_integrations") {
			
			var nom_famille = $("#td_last_name").html();
			var date_naissance = $("#td_birthday").html();

			var params = "&nom_famille=" + nom_famille + "&date_naissance=" + date_naissance + tabFlux[this.index].params;
		}
		 
		return "ajax.php?action=" + this.name + "&rn=" + mark[1] + params ;
		
	},

	reloadFluxTransaction: function() {

		if($("#tab_"+tabFlux[this.index].name).length != 0) {
				
			$( "#"+tabFlux[this.index].name ).tabs({
				beforeLoad: function( event, ui ) {
					$( '#loading' ).dialog( "open" );
					 
				},
				
				load: function ( event, ui ) {
					$( '#loading' ).dialog( "close" );
					  
				}
					
			});
				
		}

	},

	openDialog: function() {
		$("#loading").dialog( "open" );

	},
	
	closeDialog: function() {
		$("#loading").dialog( "close" );
	
	}, 
	
	counter: function() { return ++this.count }
	
};

$( function() { 

	$( "#flux_bcss" ).tabs({
		beforeLoad: function( event, ui ) {
			$( '#loading' ).dialog( "open" );
			 
		},
		
		load: function ( event, ui ) {
			$( '#loading' ).dialog( "close" );
			  
		}
		
	});
	
	$( "a.ui-tabs-anchor" ).on("click", function() {
		// Clique sur n'importe quel flux pour executer  
		var tab = $(this).attr('href');
		var spt = tab.split("#tab_");
 
		if( spt[1] != "flux_tous" ) { 
			 
			Flux.opt  = "EACH";
			Flux.name = spt[1];
			Flux.execute(); 
		}
		
	});

	$( "a[href='#tab_flux_tous']" ).on('click', function() { 
		// Executer tous les flux 
		Flux.opt  = "ALL";
		Flux.executeAll();
	});

	// On déclenche le click sur le premier élément des onglets (ui-tabs) pour obtenir les infos de ce flux
	$("a.ui-tabs-anchor").first().trigger( "click" );
	 
});

// Permet de charger les qtips rn
function qtipLoad() {

	$(".rn").each(function() {
		var rn = $(this).text();
		$(this).click(function() {
			window.location = "index.php?env=member&page=person&action=display&rn=" + rn;
		});

		$(this).qtip( {
			content: {
				url: 'ajax.php?action=flux_identify_person',
				data: {
					rn: rn
				},
				method: 'get',
				title: '<center>Informations limitées de la personne</center>'
			},
			position: {
				corner: {
					target: 'rightMiddle',
					tooltip: 'leftBottom'
				}
			},
			style: {
				name: 'dark',
				border: {
					width: 7,
					radius: 5,
					color: '#A2D959'
				},
				tip: 'leftBottom',
				width: 500
            }
		});
	});
}

</script> 
