<style>
<!--
	#identify_person {
		border: 0px;
		margin-left: 0;
		margin-right: 0;
	}
	#identify_person table tr th
	{
		text-align: right;
		text-decoration: underline;
		width: 130px;
	}
-->
</style>

<div id="identify_person">

<?php if ($res['error']): ?>
	
	<p class="error"><?php echo $res['message']; ?></p>

<?php else: ?>

<?php $personne = $res['data']; ?>

	<table width="100%">
		<tbody>
			<tr>
				<th>Numéro NISS (RN) : </th>
				<td><?php echo $personne->Basic->SocialSecurityUser; ?></td>
			</tr>
			
			<tr>
				<th>Nom : </th>
				<td><?php echo $personne->Basic->LastName; ?></td>
			</tr>
			
			<tr>
				<th>Prénom : </th>
				<td><?php echo $personne->Basic->FirstName; ?></td>
			</tr>
			
			<tr>
				<th>Date de naissance : </th>
				<td><?php echo DateIdentifyPerson::format($personne->Basic->BirthDate); ?></td>
			</tr>
			
			<tr>
				<th>Sexe : </th>
				<td><?php echo ($personne->Basic->Gender == 1)?"HOMME":"FEMME"; ?></td>
			</tr>
			
			<?php if ($personne->Basic->Address->HouseNumber > 0): ?>
			<tr>
				<th>Adresse : </th>
				<td><?php echo AdresseIdentifyPerson::format($personne->Basic->Address); ?></td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>

<?php endif; ?>

</div>