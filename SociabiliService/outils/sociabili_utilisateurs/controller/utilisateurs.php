<?php

if ($_SESSION['is_connected_'.$applicationName])
{
	require_once 'model/utilisateur.php';

	$erreur = '';
	$action = null;
	if (isset($_GET['action']))
	{
		$action = $_GET['action'];
	}

	// Connexion à la DB
	$connexion = oci_connect($login, $password, $tn, 'AL32UTF8');

    switch($action)
    {
		case 'lister':
			// Récupérations des localisations
			$utilisateurs = Utilisateur::getFromDatabase($connexion);

			// Passage à la vue
			include_once 'view/utilisateurs/lister.php';

			break;

		case 'ajouter':
    		if ((isset($_POST['ajouter-utilisateur'])) && (!empty($_POST['ajouter-utilisateur'])))
			{
				require_once 'model/utilisateur.php';

				$erreur = "";
				$validation = "";

				$id_utilisateur = Utilisateur::existe($connexion, $_POST['nom'], $_POST['prenom'], $_POST['samaccountname']);
				if ($id_utilisateur == -1)
				{
					$erreur = "Il est impossible d'ajouter un utilisateur";
					include_once 'view/message.php';
					header("Refresh: 1; url=".$baseUrl."utilisateurs/modifier/".$id_utilisateur);
				}
				elseif ($id_utilisateur == 0)
				{
					$newUtilisateur = new Utilisateur($connexion);
					$newUtilisateur->setPrenom($_POST['prenom']);
					$newUtilisateur->setNom($_POST['nom']);
					$newUtilisateur->setCodeAs($_POST['code_as']);
					$newUtilisateur->setSamaccountname($_POST['samaccountname']);

					if ($newUtilisateur->ajouter() == true)
					{
						$validation = "L'utilisateur a été ajouté avec succès";
						$erreur = "";

						if ((isset($_POST['id_slg'])) && (!empty($_POST['id_slg'])))
						{
							if (count($_POST['id_slg']) > 0)
							{
								foreach ($_POST['id_slg'] as $idSLG)
								{
									$newUtilisateur->ajouterSLG($idSLG);
								}
							}
						}
					}
					else
					{
						$validation = "";
						$erreur = "Impossible d'ajouter l'utilisateur";
					}

					include_once 'view/message.php';
					header("Refresh: 1; url=".$baseUrl."utilisateurs/membre_de/".$newUtilisateur->getId());
				}
				else
				{
					$validation = "L'utilisateur existe déjà";

					include_once 'view/message.php';
					header("Refresh: 1; url=".$baseUrl."utilisateurs/lister");
				}
			}
			else
			{
				require_once 'model/service_localisation_groupe.php';

				$slgs = ServiceLocalisationGroupe::getFromDatabase($connexion);

				include_once 'view/utilisateurs/ajouter.php';
			}

			break;

		case 'supprimer':
			$oldUtilisateur = new Utilisateur($connexion);
			$oldUtilisateur->setFromDatabase($_GET['id']);

			if ($oldUtilisateur->supprimer() == true)
			{
				$nbSLGs = $oldUtilisateur->supprimerSLGs();

				$erreur = "";
				$validation = "L'utilisateur a été supprimé avec succès avec ses ".$nbSLGs." SLG(s)";
			}
			else
			{
				$erreur = "Impossible de supprimer l'utilisateur";
				$validation = "";
			}

			include_once 'view/message.php';
			header("Refresh: 1; url=".$baseUrl."utilisateurs/lister");

			break;

		case 'modifier':
			if ((isset($_GET['id'])) && (!empty($_GET['id'])))
			{
				$slgs = ServiceLocalisationGroupe::getFromDatabase($connexion);

				$utilisateur = new Utilisateur($connexion);
				$utilisateur->setFromDatabase($_GET['id']);

	    		if ((isset($_POST['modifier-utilisateur'])) && (!empty($_POST['modifier-utilisateur'])))
				{
					$validation = "";
					$erreur = "";

					$utilisateur->setPrenom($_POST['prenom']);
					$utilisateur->setNom($_POST['nom']);
					$utilisateur->setCodeAs($_POST['code_as']);
					$utilisateur->setSamaccountname($_POST['samaccountname']);
					if ($utilisateur->modifier() == true)
					{
						$nbAjouts = 0;
						if (count($_POST['id_slg']) > 0)
						{
							foreach ($_POST['id_slg'] as $idSLG)
							{
								if ($utilisateur->aPourSLG($idSLG) == false)
								{
									$slg = new ServiceLocalisationGroupe($connexion);
									$slg->setFromDatabase($idSLG);

									if ($utilisateur->ajouterSLG($idSLG) == true)
									{
										$nbAjouts++;
									}
									unset($slg);
								}
							}
						}
						$nbSuppressions = 0;
						if (count($utilisateur->getIdSLGs()) > 0)
						{
							foreach ($utilisateur->getIdSLGs() as $idSLG)
							{
								if (in_array($idSLG, $_POST['id_slg']) == false)
								{
									if ($utilisateur->supprimerSLG($idSLG) == true)
									{
										$nbSuppressions++;
									}
								}
							}
						}

						if (($nbAjouts > 0) || ($nbSuppressions > 0))
						{
							$validation = "L'utilisateur a été modifié avec succès.<br />";
							$validation .= $nbAjouts." SLG(s) (a)(ont) été ajouté(s) et ".$nbSuppressions." a(ont) été supprimé(s) au membre <br />".$utilisateur->getNom()." ".$utilisateur->getPrenom();
							$erreur = "";
						}
						else
						{
							$erreur = "Impossible d'ajouter le SLG au membre";
							$validation = "";
						}
					}
					else
					{
						$validation = "Impossible de modifier L'utilisateur";
					}

					include_once 'view/message.php';
					header("Refresh: 1; url=".$baseUrl."utilisateurs/lister");
				}
				else
				{
					include_once 'view/utilisateurs/modifier.php';
				}
			}
			else
			{
				$erreur = "Aucun utilisateur sélectionné";
				$validation = "";

				include_once 'view/message.php';
				header("Refresh: 1; url=".$baseUrl."utilisateurs/lister");
			}

			break;

		case 'ajouter_slg':
			if ((isset($_GET['id'])) && (!empty($_GET['id'])))
			{
				$utilisateur = new Utilisateur($connexion);
				$utilisateur->setFromDatabase($_GET['id']);

				if ((isset($_POST['ajouter_utilisateur_slg'])) && (!empty($_POST['ajouter_utilisateur_slg'])))
				{
					$nbAjouts = 0;
					if (count($_POST['id_slg']) > 0)
					{
						foreach ($_POST['id_slg'] as $idSLG)
						{
							if ($utilisateur->aPourSLG($idSLG) == false)
							{
								$slg = new ServiceLocalisationGroupe($connexion);
								$slg->setFromDatabase($idSLG);

								if ($utilisateur->ajouterSLG($idSLG) == true)
								{
									$nbAjouts++;
								}
								unset($slg);
							}
						}
					}
					$nbSuppressions = 0;
					if (count($utilisateur->getIdSLGs()) > 0)
					{
						foreach ($utilisateur->getIdSLGs() as $idSLG)
						{
							if (in_array($idSLG, $_POST['id_slg']) == false)
							{
								if ($utilisateur->supprimerSLG($idSLG) == true)
								{
									$nbSuppressions++;
								}
							}
						}
					}

					if (($nbAjouts > 0) || ($nbSuppressions > 0))
					{
						$validation = $nbAjouts." SLG(s) (a)(ont) été ajouté(s) et ".$nbSuppressions." a(ont) été supprimé(s) au membre <br />".$utilisateur->getNom()." ".$utilisateur->getPrenom();
						$erreur = "";
					}
					else
					{
						$erreur = "Impossible d'ajouter le SLG au membre";
						$validation = "";
					}

					include_once 'view/message.php';
					header("Refresh: 1; url=".$baseUrl."utilisateurs/membre_de/".$utilisateur->getId());
				}
				else
				{
					$slgs = ServiceLocalisationGroupe::getFromDatabase($connexion);
					include_once 'view/utilisateurs/ajouter_slg.php';
				}
			}
			else
			{
				$erreur = "Aucun utilisateur sélectionné";
				$validation = "";

				include_once 'view/message.php';
				header("Refresh: 1; url=".$baseUrl."utilisateurs/lister");
			}


			break;

		case 'supprimer_slg':

			if ((isset($_GET['id'])) && (!empty($_GET['id'])))
			{
				$ids = explode('-', $_GET['id']);

				$utilisateur = new Utilisateur($connexion);
				$utilisateur->setFromDatabase($ids[1]);

				if ($utilisateur->supprimerSLG($ids[0]) == true)
				{
					$erreur = "";
					$validation = "Le SLG a été supprimé avec succès pour cet utilisateur";
				}
				else
				{
					$erreur = "Impossible de supprimer le SLG de cet utilisateur";
					$validation = "";
				}

				include_once 'view/message.php';
				header("Refresh: 1; url=".$baseUrl."services_localisations_groupes/membres/".$ids[0]);
			}
    		else
			{
				$erreur = "Impossible de supprimer le SLG de cet utilisateur";
				$validation = "";

				include_once 'view/message.php';
				header("Refresh: 1; url=".$baseUrl."utilisateurs/lister");
			}

			break;

		case 'importer':
			$debug = "";
			if (isset($_FILES['fichier']))
			{
				$file = $_FILES['fichier'];
				$infos_fichier = explode(".", $file['name']);

				if ($infos_fichier[(count($infos_fichier)-1)] == "csv")
				{
					if (file_exists($file['tmp_name']))
					{
						// Création du modèle ImportUtilisateurs
						require_once 'model/import_utilisateurs.php';
						$import_utilisateur = new ImportUtilisateurs($connexion);

						// Lecture du fichier
						$fichier = file($file['tmp_name']);

						// Vérification de l'existence de lignes dans le fichier
						$nb_lignes = count($fichier);
						if ($nb_lignes > 0)
						{
							// Valeurs par défaut
							$key_nom = 3;
							$key_prenom = 4;
							$key_service = 1;
							$key_localisation = 2;
							$key_groupe = 5;

							$valeurs = explode(";", $fichier[0]);
							foreach ($valeurs as $num_col=>$valeur)
							{
								if (!empty($valeur))
								{
									switch ($valeur)
									{
										case "Service":
											$key_service = $num_col;
										break;

										case "Site":
											$key_localisation = $num_col;
										break;

										case "Nom":
											$key_nom = $num_col;
										break;

										case "Prénom":
											$key_prenom = $num_col;
										break;

										case "Grade":
											$key_groupe = $num_col;
										break;
									}
								}
							}

							$cpt=1;
							$nb_connus=0;
							for ($i=1;$i<$nb_lignes;$i++)
							{
								// Explosion des valeurs du record
								$valeurs = explode(';', $fichier[$i]);

								for ($j=1;$j<=5;$j++)
								{
									$nom = $valeurs[$key_nom];
									$prenom = supprimer_accents(utf8_encode($valeurs[$key_prenom]));
									$id_service = $valeurs[$key_service];
									$id_localisation = $valeurs[$key_localisation];
									$id_groupe = $valeurs[$key_groupe];
								}

								// RECHERCHE DE ID_UTILISATEUR
								$id_utilisateur = $import_utilisateur->recherche_utilisateur($nom, $prenom);
								if ($id_utilisateur == -1)
								{
									$debug .= "<p class='nok'>".$cpt.") ".$nom." ".$prenom." ERREUR</p>";
								}
								else
								{
									// L'utilisateur existe
									if ($id_utilisateur > 0)
									{
										$debug .= "<p class='ok'>".$cpt.") ".$nom." ".$prenom." (".$id_utilisateur.")</p>";
									}
									// L'utilisateur n'existe pas => INSERTION DE L'UTILISATEUR
									else
									{
										$debug .= "<p class='info'>".$cpt.") ".$nom." ".$prenom." (".$id_utilisateur.")</p>";

										$id_utilisateur = $import_utilisateur->ajouter_utilisateur($nom, $prenom);
										if ($id_utilisateur > 0)
										{
											$debug .= "<p class='ok'>=> Utilisateur ".$nom." ".$prenom." (".$id_utilisateur.") ajouté avec succès</p>";
										}
										else
										{
											$debug .= "<p class='nok'>=> Utilisateur ".$nom." ".$prenom." (".$id_utilisateur.") impossible à ajouter</p>";
										}
									}
								}

								if ($id_utilisateur > 0)
								{
									// RECHERCHE DE ID_LAISON_LOC_GROUP_SERV
									$id_liaison_loc_group_serv = $import_utilisateur->recherche_liaison_slg($id_localisation, $id_service, $id_groupe);
									if ($id_liaison_loc_group_serv == -1)
									{
										$debug .= "<p class='nok'>==> ERREUR liaison SLG (L:".$id_localisation.", G:".$id_groupe.", S:".$id_service.")</p>";
									}
									else
									{
										// La liaison SLG existe
										if ($id_liaison_loc_group_serv > 0)
										{
											$debug .= "<p class='info'>==> ID de la liaison SLG = ".$id_liaison_loc_group_serv." (L:".$id_localisation.", G:".$id_groupe.", S:".$id_service.")</p>";
										}
										// La liaison SLG n'existe pas => On la crée
										else
										{
											$id_liaison_loc_group_serv = $import_utilisateur->ajouter_liaison_slg($id_localisation, $id_service, $id_groupe);
											if ($id_liaison_loc_group_serv > 0)
											{
												$debug .= "<p class='info'>==> création de la liaison SLG (".$id_liaison_loc_group_serv.")</p>";
											}
											else
											{
												$debug .= "<p class='nok'>==> IMPOSSIBLE de créer la liaison SLG</p>";
											}
										}
									}

									// La liaison SLG existe
									if ($id_liaison_loc_group_serv > 0)
									{
										// RECHERCHE DE L'EXISTENCE DE LA LIAISON ENTRE UTILISATEUR ET SLG
										$test_recherche = $import_utilisateur->recherche_liaison_utilisateur_liaison_slg($id_utilisateur, $id_liaison_loc_group_serv);
										if ($test_recherche == -1)
										{
											$debug .= "<p class='nok'>====> Impossible d'effectuer la recherche de la liaison entre cet utilisateur et la liaison SLG</p>";
										}
										elseif ($test_recherche == 1)
										{
											$debug .= "<p class='ok'>====> L'utilisateur $nom $prenom ($id_utilisateur) est déjà lié avec la liaison SLG ($id_liaison_loc_group_serv)</p>";
										}
										else
										{
											$debug .= "<p class='info'>====> Liaison entre utilisateur et liaison SLG inexistante => création de celle-ci</p>";

											if ($import_utilisateur->ajouter_liaison_utilisateur_liaison_slg($id_utilisateur, $id_liaison_loc_group_serv))
											{
												$debug .= "<p class='ok'>====> L'utilisateur $nom $prenom ($id_utilisateur) est maintenant lié avec la liaison SLG ($id_liaison_loc_group_serv)</p>";
											}
											else
											{
												$debug .= "<p class='nok'>====> Impossible d'insérer la liaison entre cet utilisateur et la liaison SLG</p>";
											}
										}
									}
									$nb_connus++;
								}

								$debug .= "<br />";
								$cpt++;
							}

							$validation = 	"Importation de ".$nb_connus." sur ".($cpt-1)." utilisateurs <br />";
							$validation .=  "depuis le fichier '".$file['name']."' effectuée";
						}
						else
						{
							$erreur = "Le fichier '".$file['name']."' ne possède pas de données";
						}


					}
					else
					{
						$erreur = "Le fichier n'existe pas";
					}
				}
				else
				{
					$erreur = "Le fichier n'est pas un CSV";
				}


				include_once 'view/message.php';
			}
			else
			{
				include_once 'view/utilisateurs/importer.php';
			}

			break;

		case 'exporter':
			$utilisateurs = Utilisateur::getFromDatabase($connexion);

			$fileName = tempnam(sys_get_temp_dir(), 'utilisateurs');
			$file = fopen($fileName, 'w');
			$ligne = ";Nom;Prenom;Samaccountname;Service;Localisation;Groupe;\n";
			fputs($file, $ligne);
			$i = 1;
			foreach ($utilisateurs as $utilisateur)
			{
				$ligne = "";
				if ($utilisateur->getId() != 0)
				{
					$utilisateurLigne = $utilisateur->getNom().";".$utilisateur->getPrenom().";".$utilisateur->getSamaccountname().";";
					$slgs = $utilisateur->getSLGs();

					if (count($slgs) > 0)
					{
						foreach ($slgs as $slg)
						{
							$ligne = $i.";".$utilisateurLigne.$slg->getService()->getNom().";".$slg->getLocalisation()->getNom().";".$slg->getGroupe()->getNom().";\n";
							fputs($file, $ligne);

							$i++;
						}
					}
					else
					{
						$ligne = $i.";".$utilisateurLigne.";;;\n";
						fputs($file, $ligne);

						$i++;
					}
				}
			}
			fclose($file);
			fclose($file);

		    if (file_exists($fileName))
		    {
			    header('Content-Description: File Transfer');
			    header('Content-Type: application/octet-stream');
			    header('Content-Disposition: attachment; filename=utilisateurs.csv');
			    header('Content-Transfer-Encoding: binary');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate');
			    header('Pragma: public');
			    header('Content-Length: ' . filesize($fileName));
			    ob_clean();
			    flush();
			    readfile($fileName);

			    $validation = "Utilisateurs exportés avec succès";
				$erreur = "";
			}
			else
			{
				$validation = "";
				$erreur = "Impossible d'exporter les utilisateurs";
			}
			unlink($fileName);

			include_once 'view/message.php';

			break;

		case 'membre_de':
    		if ((isset($_GET['id'])) && (!empty($_GET['id'])))
			{
				$utilisateur = new Utilisateur($connexion);
				$utilisateur->setFromDatabase($_GET['id']);

				// Récupération des SLGs dont est membre l'utilisateur
				$slgs = $utilisateur->getSLGs();

				// Passage à la vue
				include_once 'view/utilisateurs/membre_de.php';
			}
			else
			{
				$erreur = "Aucun utilisateur selectionné";
				include_once 'view/message.php';

				header("Refresh: 1; url=".$baseUrl."utilisateurs/lister");
			}

			break;

		default:
			//Redirection
			header("Location: ".$baseUrl."utilisateurs/lister");

			break;
    }
}
else
{
    header('Location: '.$baseUrl);
}
