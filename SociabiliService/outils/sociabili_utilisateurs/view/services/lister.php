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

<h1 class="titre-gauche">Lister les services</h1><h1 class="titre-droite"><a class="ajouter" href="<?php echo $baseUrl; ?>services/ajouter">Ajouter</a> | <a class="imprimer" href="javascript:window.print()">Imprimer</a></h1>
<br style="clear:both;" />
<hr>

<table class="tableau">
	<thead>
		<tr>
			<th>ID</th>
			<th>NOM</th>
			<th width="80px" />
		</tr>
	</thead>
	
	</tbody>
		
<?php foreach ($services as $service): ?>
		
		<tr>
			<td><?php echo $service->getId(); ?></td>
			<td><?php echo $service->getNom(); ?></td>
			<td>
				<a title="Modifier" href="<?php echo $baseUrl; ?>services/modifier/<?php echo $service->getId(); ?>"><img src="<?php echo $baseUrl; ?>includes/images/modifier.png"></img></a>
				<a title="Supprimer" href="#" onclick="javascript:confirmation('<?php echo $baseUrl; ?>services/supprimer/<?php echo $service->getId(); ?>');"><img src="<?php echo $baseUrl; ?>includes/images/supprimer.png"></img></a>
			</td>
		</tr>
		
<?php endforeach; ?>

	</tbody>

</table>

<div id="dialog-confirmation" title="Confirmation de suppression">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous supprimer ce service?</p>
</div>
