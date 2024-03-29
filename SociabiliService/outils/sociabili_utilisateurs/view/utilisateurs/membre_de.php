<script type="text/javascript">
<!--
	$(document).ready(function() {
		$(".tableau").dataTable( {
			"aaSorting": [[ 0, "asc" ]],
			"sPaginationType": "full_numbers",
			"bJQueryUI": true,
			"oLanguage": {
			    "sProcessing":   "Traitement en cours...",
			    "sLengthMenu":   "Eléments à afficher: _MENU_",
			    "sZeroRecords":  "Aucun élément à afficher",
			    "sInfo":         "Affichage de l'élement _START_ à _END_ sur _TOTAL_ éléments",
			    "sInfoEmpty":    "Affichage de l'élement 0 à 0 sur 0 éléments",
			    "sInfoFiltered": "(filtré de _MAX_ éléments au total)",
			    "sInfoPostFix":  "",
			    "sSearch":       "Rechercher :",
			    "sUrl":          "",
			    "oPaginate": {
			        "sFirst":    "Premier",
			        "sPrevious": "Précédent",
			        "sNext":     "Suivant",
			        "sLast":     "Dernier"
			    }
			}
		} );

		$("#dialog-confirmation").dialog( {
			autoOpen: false,
			resizable: false,
			width: 340,
			height: 140,
			modal: true
		} );
	} );

	function confirmation(url)
	{
		$("#dialog-confirmation").dialog( {
			buttons : {
				"Oui" : function() {
					$(this).dialog("destroy");
					window.location.href = url;
				},
				"Non" : function() {
					$(this).dialog("close");
				}
			}
		} );
	
		$("#dialog-confirmation").dialog("open");
	}
	
//-->
</script>

<h1 class="titre-gauche">SLGs dont est membre <br /><?php echo $utilisateur->getNom(); ?> <?php echo $utilisateur->getPrenom(); ?> (<a href="<?php echo $baseUrl; ?>utilisateurs/modifier/<?php echo $utilisateur->getId(); ?>"><?php echo $utilisateur->getId(); ?></a>)</h1><h1 class="titre-droite"><a class="ajouter" href="<?php echo $baseUrl; ?>utilisateurs/ajouter_slg/<?php echo $utilisateur->getId(); ?>">Ajouter SLG(s)</a> | <a class="imprimer" href="javascript:window.print()">Imprimer</a></h1>
<br style="clear:both;" />
<hr>

<table class="tableau">
	<thead>
		<tr>
			<th>ID</th>
			<th>SERVICE</th>
			<th>LOCALISATION</th>
			<th>GROUPE</th>
			<th width="80px" />
		</tr>
	</thead>
	
	</tbody>
		
<?php foreach ($slgs as $slg): ?>
		
		<tr>
			<td><?php echo $slg->getId(); ?></td>
			<td><?php echo $slg->getService()->getNom(); ?> (<?php echo $slg->getService()->getId(); ?>)</td>
			<td><?php echo $slg->getLocalisation()->getNom(); ?> (<?php echo $slg->getLocalisation()->getId(); ?>)</td>
			<td><?php echo $slg->getGroupe()->getNom(); ?> (<?php echo $slg->getGroupe()->getId(); ?>)</td>
			<td>
				<a title="Supprimer SLG" href="#" onclick="javascript:confirmation('<?php echo $baseUrl; ?>services_localisations_groupes/supprimer_membre/<?php echo $utilisateur->getId(); ?>-<?php echo $slg->getId(); ?>');"><img src="<?php echo $baseUrl; ?>includes/images/supprimer.png"></img></a>
				| <a title="Lister les membres" href="<?php echo $baseUrl; ?>services_localisations_groupes/membres/<?php echo $slg->getId(); ?>"><img src="<?php echo $baseUrl; ?>includes/images/membres.png"></img></a>
			</td>
		</tr>
		
<?php endforeach; ?>

	</tbody>

</table>

<div id="dialog-confirmation" title="Confirmation de suppression">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous supprimer ce SLG pour le membre?</p>
</div>
