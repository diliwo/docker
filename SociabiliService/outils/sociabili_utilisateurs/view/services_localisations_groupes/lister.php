<script type="text/javascript">
<!--
	$(document).ready(function() {
		$(".tableau").dataTable( {
			"aaSorting": [[ 2, "asc" ]],
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
			autoOpen: false,
			resizable: false,
			width: 340,
			height: 140,
			modal: true,
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

<h1 class="titre-gauche">Lister les SLGs</h1><h1 class="titre-droite"><a class="ajouter" href="<?php echo $baseUrl; ?>services_localisations_groupes/ajouter">Ajouter</a> | <a class="imprimer" href="javascript:window.print()">Imprimer</a></h1>
<br style="clear:both;" />
<hr>

<table class="tableau">
	<thead>
		<tr>
			<th>D</th>
			<th>M</th>
			<th>ID</th>
			<th>SERVICE</th>
			<th>LOCALISATION</th>
			<th>GROUPE</th>
			<th width="120px" />
		</tr>
	</thead>
	
	</tbody>
		
<?php foreach ($slgs as $slg): ?>
		
		<tr>
			<?php if ($slg->aLesDroitsFenetre() == true): ?>
			<td><span style="display: none;">1</span> <img src="<?php echo $baseUrl; ?>includes/images/valider.png"></img></td>
			<?php else: ?>
			<td><span style="display: none;">0</span> <img src="<?php echo $baseUrl; ?>includes/images/nonvalider.png"></td>
			<?php endif; ?>
			
			<?php if ($slg->getGroupe()->getNom() == "MANAGER"): ?>
				<?php if (count($slg->getIdMembres()) == 0): ?>
				<td><span style="display: none;">0</span> <img src="<?php echo $baseUrl; ?>includes/images/nonvalider.png"></img></td>
				<?php elseif (count($slg->getIdMembres()) == 1): ?>
				<td><span style="display: none;">1</span> <img src="<?php echo $baseUrl; ?>includes/images/valider.png"></img></td>
				<?php else: ?>
				<td><span style="display: none;">-1</span> <img src="<?php echo $baseUrl; ?>includes/images/attention.png"></img></td>
				<?php endif; ?>
			
			<?php else: ?>
				<td><span style="display: none;">2</span></td>
			<?php endif; ?>
			
			<td><?php echo $slg->getId(); ?></td>
			<td><?php echo $slg->getService()->getNom(); ?> (<?php echo $slg->getService()->getId(); ?>)</td>
			<td><?php echo $slg->getLocalisation()->getNom(); ?> (<?php echo $slg->getLocalisation()->getId(); ?>)</td>
			<td><?php echo $slg->getGroupe()->getNom(); ?> (<?php echo $slg->getGroupe()->getId(); ?>)</td>
			<td>
				<a title="Modifier" href="<?php echo $baseUrl; ?>services_localisations_groupes/modifier/<?php echo $slg->getId(); ?>"><img src="<?php echo $baseUrl; ?>includes/images/modifier.png"></img></a>
				<a title="Supprimer" href="#" onclick="javascript:confirmation('<?php echo $baseUrl; ?>services_localisations_groupes/supprimer/<?php echo $slg->getId(); ?>');"><img src="<?php echo $baseUrl; ?>includes/images/supprimer.png"></img></a>
				| <a title="Ajouter membre(s)" href="<?php echo $baseUrl; ?>services_localisations_groupes/ajouter_membre/<?php echo $slg->getId(); ?>"><img src="<?php echo $baseUrl; ?>includes/images/ajouter.png"></img></a>
				<a title="Lister les membres" href="<?php echo $baseUrl; ?>services_localisations_groupes/membres/<?php echo $slg->getId(); ?>"><img src="<?php echo $baseUrl; ?>includes/images/membres.png"></img></a>
			</td>
		</tr>
		
<?php endforeach; ?>

	</tbody>

</table>

<div id="dialog-confirmation" title="Confirmation de suppression">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous supprimer ce SLG et toutes les liaisons avec les utilisateurs?</p>
</div>
