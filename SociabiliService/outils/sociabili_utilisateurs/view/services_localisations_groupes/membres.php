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

<h1 class="titre-gauche">Membres du SLG <br /><?php echo $slg->getService()->getNom(); ?> - <?php echo $slg->getLocalisation()->getNom(); ?> - <?php echo $slg->getGroupe()->getNom(); ?> (<a href="<?php echo $baseUrl; ?>services_localisations_groupes/modifier/<?php echo $slg->getId(); ?>"><?php echo $slg->getId(); ?></a>)</h1><h1 class="titre-droite"><a class="ajouter" href="<?php echo $baseUrl; ?>services_localisations_groupes/ajouter_membre/<?php echo $slg->getId(); ?>">Ajouter membre(s)</a> | <a class="imprimer" href="javascript:window.print()">Imprimer</a></h1>
<br style="clear:both;" />
<hr>

<table class="tableau">
	<thead>
		<tr>
			<th width="50px">ID</th>
			<th width="150px">NOM</th>
			<th width="150px">PRENOM</th>
			<th width="100px">CODE AS</th>
			<th width="200px">SAMACCOUNTNAME</th>
			<th width="70px" />
		</tr>
	</thead>
	
	</tbody>
		
<?php foreach ($membres as $membre): ?>
		
		<tr>
			<td><?php echo $membre->getId(); ?></td>
			<td><?php echo $membre->getNom(); ?></td>
			<td><?php echo $membre->getPrenom(); ?></td>
			<td><?php echo $membre->getCodeAs(); ?></td>
			<td><?php echo $membre->getSamaccountname(); ?></td>
			<td>
				<a title="Supprimer membre" href="#" onclick="javascript:confirmation('<?php echo $baseUrl; ?>utilisateurs/supprimer_slg/<?php echo $slg->getId(); ?>-<?php echo $membre->getId(); ?>');"><img src="<?php echo $baseUrl; ?>includes/images/supprimer.png"></img></a>
				| <a title="Lister les SLGs" href="<?php echo $baseUrl; ?>utilisateurs/membre_de/<?php echo $membre->getId(); ?>"><img src="<?php echo $baseUrl; ?>includes/images/lister.png"></img></a>
			</td>
		</tr>
		
<?php endforeach; ?>

	</tbody>

</table>

<div id="dialog-confirmation" title="Confirmation de suppression">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous supprimer ce membre du SLG?</p>
</div>
