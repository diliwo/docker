<?php

$_config['ldap'] = array(
	'domain_controllers' => array('dc03.cpas.schaerbeek.dom'),
	'base_dn' => 'DC=cpas,DC=schaerbeek,DC=dom',
	'account_suffix' => '@cpas.schaerbeek.dom',
	'groupes' => array(
		'utilisateurs' 		=> "CN=utilisateurs_bcss,OU=BCSS,OU=Sociabili,OU=CPAS-applications,DC=cpas,DC=schaerbeek,DC=dom",
		'administrateurs' 	=> "CN=administrateurs_bcss,OU=BCSS,OU=Sociabili,OU=CPAS-applications,DC=cpas,DC=schaerbeek,DC=dom",
		'droits' => array(
			't25' 			=> "CN=GG_BCSS_T25,OU=BCSS,OU=Sociabili,OU=CPAS-applications,DC=cpas,DC=schaerbeek,DC=dom",
			'taxi_as'		=> "CN=GG_BCSS_TAXI_AS,OU=BCSS,OU=Sociabili,OU=CPAS-applications,DC=cpas,DC=schaerbeek,DC=dom",
			'soctar' 		=> "CN=GG_BCSS_SOCTAR,OU=BCSS,OU=Sociabili,OU=CPAS-applications,DC=cpas,DC=schaerbeek,DC=dom",
		)
	)
);
