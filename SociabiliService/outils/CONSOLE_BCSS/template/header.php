<header class="navbar navbar-static-top navbar-inverse">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.php">
				Console BCSS
			</a>
		</div>

		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"> Environements <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li <?php if ($_SESSION['test_flux_bcss']['env'] == 'test') echo 'class="active"'; ?>><a href="index.php?env=test">Test</a></li>
						<li <?php if ($_SESSION['test_flux_bcss']['env'] == 'acpt') echo 'class="active"'; ?>><a href="index.php?env=acpt">Acceptation</a></li>
						<li <?php if ($_SESSION['test_flux_bcss']['env'] == 'prod') echo 'class="active"'; ?>><a href="index.php?env=prod">Production</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Flux <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li <?php if (isset($_GET['page']) && $_GET['page'] == 'alert_reaction') echo 'class="active"'; ?>><a href="index.php?page=alert_reaction">AlertReaction</a></li>
						<li <?php if (isset($_GET['page']) && $_GET['page'] == 'cadnet') echo 'class="active"'; ?>><a href="index.php?page=cadnet">Cadnet</a></li>
						<li <?php if (isset($_GET['page']) && $_GET['page'] == 'childbenefits') echo 'class="active"'; ?>><a href="index.php?page=childbenefits">ChildBenefits</a></li>	
						<li <?php if (isset($_GET['page']) && $_GET['page'] == 'dimona') echo 'class="active"'; ?>><a href="index.php?page=dimona">Dimona</a></li>
						<li <?php if (isset($_GET['page']) && $_GET['page'] == 'dolsis') echo 'class="active"'; ?>><a href="index.php?page=dolsis">Dolsis</a></li>
						<li <?php if (isset($_GET['page']) && $_GET['page'] == 'family_allowances_service') echo 'class="active"'; ?>><a href="index.php?page=family_allowances_service">FamilyAllowancesService</a></li> 
						<li <?php if (isset($_GET['page']) && $_GET['page'] == 'handiflux') echo 'class="active"'; ?>><a href="index.php?page=handiflux">HandiFlux</a></li>
						<li <?php if (isset($_GET['page']) && $_GET['page'] == 'health_care_insurance') echo 'class="active"'; ?>><a href="index.php?page=health_care_insurance">HealthCareInsurance</a></li>
						<li <?php if (isset($_GET['page']) && $_GET['page'] == 'identify_person') echo 'class="active"'; ?>><a href="index.php?page=identify_person">IdentifyPerson</a></li>
						<li <?php if (isset($_GET['page']) && $_GET['page'] == 'list_of_attestation') echo 'class="active"'; ?>><a href="index.php?page=list_of_attestation">ListOfAttestation</a></li>
						<li <?php if (isset($_GET['page']) && $_GET['page'] == 'living_wages') echo 'class="active"'; ?>><a href="index.php?page=living_wages">LivingWages</a></li>
						<li <?php if (isset($_GET['page']) && $_GET['page'] == 'manage_access') echo 'class="active"'; ?>><a href="index.php?page=manage_access">ManageAccess</a></li>
						<li <?php if (isset($_GET['page']) && $_GET['page'] == 'patrimony_service') echo 'class="active"'; ?>><a href="index.php?page=patrimony_service">PatrimonyService</a></li>
						<li <?php if (isset($_GET['page']) && $_GET['page'] == 'pension_register') echo 'class="active"'; ?>><a href="index.php?page=pension_register">PensionRegister</a></li>
						<li class="dropdown-submenu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">RetrieveTiGroups <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li <?php if (isset($_GET['page']) && $_GET['page'] == 'transaction25_v1') echo 'class="active"'; ?>><a href="index.php?page=transaction25_v1">V1</a></li>
								<li <?php if (isset($_GET['page']) && $_GET['page'] == 'transaction25_v2') echo 'class="active"'; ?>><a href="index.php?page=transaction25_v2">V2</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">SelfEmployed <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li <?php if (isset($_GET['page']) && $_GET['page'] == 'self_employed_v1') echo 'class="active"'; ?>><a href="index.php?page=self_employed_v1">V1</a></li>
								<li <?php if (isset($_GET['page']) && $_GET['page'] == 'self_employed_v2') echo 'class="active"'; ?>><a href="index.php?page=self_employed_v2">V2</a></li>
							</ul>
						</li>
						<li <?php if (isset($_GET['page']) && $_GET['page'] == 'social_rate_investigation') echo 'class="active"'; ?>><a href="index.php?page=social_rate_investigation">SocialRateInvestigation</a></li>
						<li class="dropdown-submenu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">TaxAssessmentData <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li <?php if (isset($_GET['page']) && $_GET['page'] == 'taxi_as_v1') echo 'class="active"'; ?>><a href="index.php?page=taxi_as_v1">V1</a></li>
								<li <?php if (isset($_GET['page']) && $_GET['page'] == 'taxi_as_v2') echo 'class="active"'; ?>><a href="index.php?page=taxi_as_v2">V2</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">UnemploymentData <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li <?php if (isset($_GET['page']) && $_GET['page'] == 'unemployment_data_v1') echo 'class="active"'; ?>><a href="index.php?page=unemployment_data_v1">V1</a></li>
								<li <?php if (isset($_GET['page']) && $_GET['page'] == 'unemployment_data_v2') echo 'class="active"'; ?>><a href="index.php?page=unemployment_data_v2">V2</a></li>
								<li <?php if (isset($_GET['page']) && $_GET['page'] == 'unemployment_data_v3') echo 'class="active"'; ?>><a href="index.php?page=unemployment_data_v3">V3</a></li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		
	</div>
</header>
