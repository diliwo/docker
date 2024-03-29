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

<h1 class="titre-gauche">Lister les utilisateurs</h1><h1 class="titre-droite"><a class="ajouter" href="<?php echo $baseUrl; ?>utilisateurs/ajouter">Ajouter</a> | <a class="importer" href="<?php echo $baseUrl; ?>utilisateurs/importer">Importer</a> | <a class="exporter" href="<?php echo $baseUrl; ?>utilisateurs/exporter">Exporter</a> | <a class="imprimer" href="javascript:window.print()">Imprimer</a></h1>
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
			<th width="110px" />
		</tr>
	</thead>
	
	</tbody>
		
<?php foreach ($utilisateurs as $utilisateur): ?>
		
		<tr>
			<td><?php echo $utilisateur->getId(); ?></td>
			<td><?php echo $utilisateur->getNom(); ?></td>
			<td><?php echo $utilisateur->getPrenom(); ?></td>
			<td><?php echo $utilisateur->getCodeAs(); ?></td>
			<td><?php echo $utilisateur->getSamaccountname(); ?></td>
			<td>
				<a title="Modifier" href="<?php echo $baseUrl; ?>utilisateurs/modifier/<?php echo $utilisateur->getId(); ?>"><img src="<?php echo $baseUrl; ?>includes/images/modifier.png"></img></a>
				<a title="Supprimer" href="#" onclick="javascript:confirmation('<?php echo $baseUrl; ?>utilisateurs/supprimer/<?php echo $utilisateur->getId(); ?>');"><img src="<?php echo $baseUrl; ?>includes/images/supprimer.png"></img></a>
				| <a title="Ajouter SLG(s)" href="<?php echo $baseUrl; ?>utilisateurs/ajouter_slg/<?php echo $utilisateur->getId(); ?>"><img src="<?php echo $baseUrl; ?>includes/images/ajouter.png"></img></a>
				<a title="Lister les SLGs" href="<?php echo $baseUrl; ?>utilisateurs/membre_de/<?php echo $utilisateur->getId(); ?>"><img src="<?php echo $baseUrl; ?>includes/images/lister.png"></img></a>
			</td>
			
		</tr>
		
<?php endforeach; ?>

	</tbody>

</table>

<div id="dialog-confirmation" title="Confirmation de suppression">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous supprimer cet utilisateur et toutes les liaisons SLG?</p>
</div>
