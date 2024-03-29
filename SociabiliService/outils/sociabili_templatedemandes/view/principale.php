<?php
$DBM = new DatabaseManager();
		
	$liste_template = Template::getAllTemplate($DBM->connexionDB);
?>
<a href='index.php?page=deconnexion' style='float:right;border:solid;'>Déconnexion</a>
<br><br >
<form name="formulaire">

<section style='display:block;text-align:center;'>
	 
			<TABLE style='border:1px inset black;margin:auto;box-sizing: content-box;'> 
				<CAPTION style=font-weight:bold; > Recherche par ID</CAPTION>				
				<TR style='background-image:url(css/grey.jpg);'> 
				<TH style=text-align:center>Langue</TH> 
				<TH style=text-align:center>Type Aide</TH> 
				<TH style=text-align:center>Sous-Type Aide</TH> 
				<TH style=text-align:center>Verbe</TH> 
				<TH style=text-align:center>Libellé</TH> 
				</TR> 
				<TR> 
				<TH> 
					<select onChange='charger_liste_template();' id="code_langue_r" style="height:34px;">						
						<option value="1" selected>Français</option>
						<option value="2">Néerlandais</option>
					</select>				 
				</TH> 
				<TH> <input onChange='charger_liste_template();' type="text" name="type_aide_r" id="type_aide_r" style=width:180px;/>	 				 </TH> 
				<TH> <input onChange='charger_liste_template();' type="text" name="type_sous_type_aide_r" id="type_sous_aide_r" style=width:180px;/>	 </TH> 
				<TH> <input onChange='charger_liste_template();' type="text" name="type_verbe_r" id="type_verbe_r" style=width:180px;/>	 				 </TH> 
				<TH> <input onChange='charger_liste_template();' type="text" name="libelle_r" id="libelle_r" style=width:180px;/>	 				 </TH> 
				</TR> 
			</TABLE>

</section>	
	<br>
		<label id="titre_liste_template" for='Liste_des_templates' >Listes des templates: </label>
	
	
	<select onchange='charger_template();' name="liste_templates" id="liste_templates" size="8" style='width:100%;font-size:20px;' >

		<?php

		foreach($liste_template as $template)
		{
			echo "<option value='".$template->id_template."' >".$template->id_type." ".$template->id_sous_type." ".$template->id_verbe." ".$template->libelle." </option>\n";
		}

		?>

	</select>

	<br>
	<br>

	<table style='width:533px;text-align:centre;margin:auto;'>
		<tr>
			<td>
				<label for="type_aide" style='display:block;text-align:center;'>Langue:</label>
				<select id="code_langue" style="height:34px" disabled="true">						
					<option value="0" selected></option>
					<option value="1" >Français</option>
					<option value="2">Néerlandais</option>
				</select>	
			</td>
			<td>
				<label for="type_aide" style='display:block;text-align:center;'>Type d'aide:</label>
				<input type="text" name="type_aide" id="type_aide" disabled="true" />			
			</td>
			<td>
				<label for="sous_type_aide" style='display:block;text-align:center;' >Sous-type d'aide:</label>
				<input type="text" name="sous_type_aide" id="sous_type_aide" disabled="true" /> 
			</td>
			<td>
				<label for="verbe" style='display:block;text-align:center;' >Verbe:</label>
				<input type="text" name="verbe" id="verbe" disabled="true" />		
			</td>
		</tr>
	</table>
	
	<br>

	<div>		
		<label for="libelle" style='display:block;text-align:center;'>Libellé:</label>
		<input type="text" name="libelle" id="libelle" disabled="true" style=width:100%; />
	</div>
	
	<br>
	
	<div>
		<label for="template" style='display:block;text-align:center;'>Template:</label>
		
		<div style='display:block;text-align:right;'>
		
			<input onclick='addTemplate();' class="btn btn-default btn-lg" type="button" name="ajout" value="Ajouter un template" id="ajout"> 
			
			<input onclick='modifTemplate();' class="btn btn-default btn-lg" type="button" name="modif" value="Modifier ce template" id="modif"> 
			
			<input onclick='suppTemplate();' class="btn btn-default btn-lg" type="button" name="supp" value="Supprimer ce template" id="supp"> 
			
			<input onclick='confirm();' class="btn btn-default btn-lg" type="hidden"  name="conf" value="Confirmer"  id="conf"> 

			<input onclick='cancel();' class="btn btn-default btn-lg" type="hidden"  name="annuler" value="Annuler"  id="annuler">
		</div>
	</div>
	
		
	<div style=margin-bottom:30px;>		
		<textarea name="template" id="template" disabled="true" style='width:100%;height:600px;' ></textarea>
	</div>
	

</form>

<script>
	
	var flagAdd = 0;
	var flagMod = 0;
	
	function getListeValeur(idSelect)
	{	
		
		var elementSelect = document.getElementById(idSelect);
		
		if(elementSelect.selectedIndex == (-1))
		{ 
			
		}
		else
		{
			return elementSelect.options[elementSelect.selectedIndex].value;	
		}
	}
	
	
	function addTemplate()
	{

		$('#type_aide').val('').empty();
		$('#sous_type_aide').val('').empty();
		$('#verbe').val('').empty();
		$('#template').val('').empty();
		$('#libelle').val('').empty();
		$('#Code_langue').val('').empty();
		$('#conf').attr('type','submit');
		$('#annuler').attr('type','button');
		$("#type_aide").attr({ disabled:false });
		$("#sous_type_aide").attr({ disabled:false });
		$("#verbe").attr({ disabled:false });
		$("#libelle").attr({ disabled:false });
		$("#template").attr({ disabled:false });
		$("#code_langue").attr({ disabled:false });
		$("#ajout").attr('type','hidden');
		$("#modif").attr('type','hidden');
		$("#supp").attr('type','hidden');
			
		flagAdd = 1 ;
		
	}
	
	function modifTemplate()
	{
		if(document.getElementById('liste_templates').selectedIndex == (-1))
		{ 
			alert("Aucun template selectionné dans la liste!");	
		
		}
		else
		{
			charger_template();
			$("#liste_templates").attr({ disabled:true });
			$('#conf').attr('type','submit');
			$('#annuler').attr('type','button');
			$("#type_aide").attr({ disabled:false });
			$("#sous_type_aide").attr({ disabled:false });
			$("#verbe").attr({ disabled:false });
			$("#libelle").attr({ disabled:false });
			$("#template").attr({ disabled:false });
			$("#code_langue").attr({ disabled:false });
			$("#ajout").attr('type','hidden');
			$("#modif").attr('type','hidden');
			$("#supp").attr('type','hidden');
			flagMod = 1 ;
		}
	}
	
	function suppTemplate()
	{
		if(document.getElementById('liste_templates').selectedIndex == (-1))
		{ 
			alert("Aucun template selectionné dans la liste!");	
			cancel();
		}
		else
		{
			charger_template();
			$("#liste_templates").attr({ disabled:true });
			$('#annuler').attr('type','button');
			$('#conf').attr('type','button');
			$("#ajout").attr('type','hidden');
			$("#modif").attr('type','hidden');
			$("#supp").attr('type','hidden');
		}
		
	}
	
	function confirm()
	{
		$('#annuler').attr('type','hidden');
		$('#conf').attr('type','hidden');
		$("#liste_templates").attr({ disabled:false }); //fct pas
		
		if (flagAdd == 1)
		{	
			if(isNaN($("#type_aide").val()) != true && isNaN($("#sous_type_aide").val()) != true && isNaN($("#verbe").val()) != true && $("#code_langue").val() != 0 )
			{	
				var template = new Template(0,$("#type_aide").val(),$("#sous_type_aide").val(),$("#verbe").val(),$("#libelle").val(),$("#template").val(), $("#code_langue").val());
				
				var temp = JSON.stringify(template);
				
				$.ajax(
					{
					  url: "ajax/ajout_template.php",
					  data: { template: temp},
					  type:'POST'
					}				
				).done(function(data) {
	
				$("#liste_templates").html(data);			
				$("#debug").html(data);			
				});
				$("#type_aide").attr({ disabled:true });
				$("#sous_type_aide").attr({ disabled:true });
				$("#verbe").attr({ disabled:true });
				$("#libelle").attr({ disabled:true });
				$("#template").attr({ disabled:true });
				$("#code_langue").attr({ disabled:true });
				alert("Le template a bien été ajouté");
				$("#ajout").attr('type','button');
				$("#modif").attr('type','button');
				$("#supp").attr('type','button');
				charger_liste_template();
				flagAdd = 0;
			}
			else
			{	
				alert("Les champs \"type aide\", \"type sous-aide\" et \"type verbe\" requierent des valeurs numériques! La sélection du code langue est obligatoire!");
				$('#annuler').attr('type','button');
				$('#conf').attr('type','button');
			}
		}
		else if ( flagMod == 1)
		{		
			if(isNaN($("#type_aide").val()) != true && isNaN($("#sous_type_aide").val()) != true && isNaN($("#verbe").val()) != true  && $("#code_langue").val() != 0 )
			{
				var template = new Template(getListeValeur('liste_templates'),$("#type_aide").val(),$("#sous_type_aide").val(),$("#verbe").val(),$("#libelle").val(),$("#template").val(), $("#code_langue").val());
			
				var temp = JSON.stringify(template);				
				
				$.ajax(
					{
					  url: "ajax/modif_Template.php",
					  data: { template: temp},
					  type:'POST'
					}
				).done(function(data) {
					$("#liste_templates").html(data);	
					console.log(data);				
				});
				$("#type_aide").attr({ disabled:true });
				$("#sous_type_aide").attr({ disabled:true });
				$("#verbe").attr({ disabled:true });
				$("#libelle").attr({ disabled:true });
				$("#template").attr({ disabled:true });
				$("#code_langue").attr({ disabled:true });
				$("#ajout").attr('type','button');
				$("#modif").attr('type','button');
				$("#supp").attr('type','button');
				alert("Le template a bien été modifié");
				
				charger_liste_template();
				flagMod = 0;
			}
			else
			{
				alert("Les champs \"type aide\", \"type sous-aide\" et \"type verbe\" requierent des valeurs numériques!");
				$('#annuler').attr('type','button');
				$('#conf').attr('type','button');
			}
		}
		else
		{
			var template = new Template(getListeValeur('liste_templates')); 
			
			var temp = JSON.stringify(template);
			
			$.ajax(
				{
				  url: "ajax/supp_Template.php",
				  data: { template: temp},
				  type:'POST'
				}
			).done(function(data) {
			$("#liste_templates").html(data);			
			$("#debug").html(data);			
			});
			alert("Le template a bien été supprimé");
			$('#type_aide').val('').empty();
			$('#sous_type_aide').val('').empty();
			$('#verbe').val('').empty();
			$('#template').val('').empty();
			$('#libelle').val('').empty();
			$('#code_langue').val('0');
			$('#code_langue_r').val('1');
			$("#ajout").attr('type','button');
			$("#modif").attr('type','button');
			$("#supp").attr('type','button');
			charger_liste_template();
		}
		
	}
	
	function cancel()
	{
		$('#annuler').attr('type','hidden');
		$('#conf').attr('type','hidden');
		$("#liste_templates").attr({ disabled:false });
		$('#type_aide').val('').empty();
		$('#sous_type_aide').val('').empty();
		$('#verbe').val('').empty();
		$('#template').val('').empty();
		$('#libelle').val('').empty();
		$("#type_aide").attr({ disabled:true });
		$("#sous_type_aide").attr({ disabled:true });
		$("#verbe").attr({ disabled:true });
		$("#libelle").attr({ disabled:true });
		$("#template").attr({ disabled:true });
		$("#ajout").attr('type','button');
		$("#modif").attr('type','button');
		$("#supp").attr('type','button');
		
		if(document.getElementById('liste_templates').selectedIndex != (-1))
		{ 
			charger_template();
		}
		
		
		flagMod = 0;
		flagAdd = 0;		
	}
	
	function Template(id_template,id_type,id_sous_type,id_verbe,libelle,template, id_code_langue)
	{
		if(typeof(id_type)==='undefined')id_type = '';
		if(typeof(id_sous_type)==='undefined')id_sous_type = '';
		if(typeof(id_verbe)==='undefined')id_verbe = '';
		if(typeof(libelle)==='undefined')libelle = '';
		if(typeof(template)==='undefined')template = '';
		if(typeof(id_template)==='undefined')id_template = '';		
		if(typeof(id_code_langue)==='undefined')id_code_langue = '';		
		
		this.id_template=id_template;
		this.libelle=libelle;
		this.template=template;
		this.id_type=id_type;
		this.id_sous_type=id_sous_type;
		this.id_verbe=id_verbe;		
		this.id_code_langue=id_code_langue;		
	}

	function charger_template()
	{ 
		if(flagMod != 1)
		{
			var template = new Template(getListeValeur('liste_templates')); 
		
			var temp = JSON.stringify(template);
			
			$.ajax(
				{
				  url: "ajax/getTemplate.php",
				  data: { template: temp},
				  type:'POST'
				}
			).done(function(data) {
			
			  var object = JSON.parse(data);
			  $('#code_langue').val(object.id_code_langue);
			  $('#verbe').val(object.id_verbe);
			  $('#sous_type_aide').val(object.id_sous_type);
			  $('#type_aide').val(object.id_type);
			  
			  while(object.template.indexOf("<br>") != -1)
			  {
				object.template = object.template.replace("<br>","\n" );
			  }
			  
			  $('#template').val(object.template);
			  $('#libelle').val( object.libelle );
			});
		}
	}
	
	function charger_liste_template()
	{	
		var cl = $("#code_langue_r").val();
		var ta = $("#type_aide_r").val();
		var sta = $("#type_sous_aide_r").val();
		var verbe = $("#type_verbe_r").val();
		var libelle = $("#libelle_r").val();
		
		if(isNaN(ta) != true && isNaN(sta) != true && isNaN(verbe) != true )
		{
			if ( !cl && !ta && !sta && !verbe && !libelle){}
			else
			{
				$.ajax(
					{
					  url: "ajax/getAllTemplates.php?cl="+cl+"&ta="+ta+"&sta="+sta+"&v="+verbe+"&libelle="+libelle,
					  type:'POST'
					}
				).done(function(data) {
					$("#liste_templates").html(data);			
					//$("#debug").html(data);			
				});
			}
		}
		else
		{	
			alert("Le champs requiert une valeur numérique");
		}
		
	}
	
	
	
	
</script>
<div id='debug'>

</div>
























