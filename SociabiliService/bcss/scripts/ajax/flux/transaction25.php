<h1>Transaction 25</h1>

<?php if($res['error']): ?>

<p class="error"><?php echo $res['message']; ?></p>

<?php else: ?>

<p>Date de collecte : <?php echo DateTransaction25::format($res['data'][253]['data'][0]->Date); ?></p>
<p>Date de dernière mise-à-jour : <?php echo DateTransaction25::format($res['data'][254]['data'][0]->Date); ?></p>
<br />

<div id="flux_transaction25">
	<ul>
		<li>
			<a href="#tab-t25-informations_principales">Informations principales</a>
		</li>
		<li>
			<a href="#tab-t25-situation_administrative">Situation administrative</a>
		</li>
		<li>
			<a href="#tab-t25-documents">Documents</a>
		</li>
		<li>
			<a href="#tab-t25-famille">Famille</a>
		</li>
		<li>
			<a href="#tab-t25-adresses">Adresses</a>
		</li>
		<li>
			<a href="#tab-t25-professions">Professions</a>
		</li>
		<li>
			<a href="#tab-t25-divers">Divers</a>
		</li>
		<li>
			<a href="#tab-t25-tous">Tous</a>
		</li>
		<!-- <li>
			<a href="#tab-t25-raw">RAW</a>
		</li> -->
	</ul>
	
	<div id="tab-t25-informations_principales" class="tab-t25">
	<?php 
		include dirname(__FILE__) . "/transaction25/ti/000.php";
		include dirname(__FILE__) . "/transaction25/ti/004.php";
		include dirname(__FILE__) . "/transaction25/ti/011.php";
		include dirname(__FILE__) . "/transaction25/ti/213.php";
		include dirname(__FILE__) . "/transaction25/ti/010.php";
		include dirname(__FILE__) . "/transaction25/ti/013.php";
		include dirname(__FILE__) . "/transaction25/ti/031.php";
		include dirname(__FILE__) . "/transaction25/ti/006.php";
		include dirname(__FILE__) . "/transaction25/ti/120.php";
		include dirname(__FILE__) . "/transaction25/ti/101.php";
		include dirname(__FILE__) . "/transaction25/ti/150.php";
		include dirname(__FILE__) . "/transaction25/ti/200.php";
	?>
	</div>
	<div id="tab-t25-situation_administrative" class="tab-t25">
	<?php 
		include dirname(__FILE__) . "/transaction25/ti/200.php";
		include dirname(__FILE__) . "/transaction25/ti/202.php";
		include dirname(__FILE__) . "/transaction25/ti/205.php";
		include dirname(__FILE__) . "/transaction25/ti/206.php";
		include dirname(__FILE__) . "/transaction25/ti/207.php";
		//include dirname(__FILE__) . "/transaction25/ti/208.php";
		include dirname(__FILE__) . "/transaction25/ti/210.php";
	?>
	</div>
	<div id="tab-t25-documents" class="tab-t25">
	<?php 
		include dirname(__FILE__) . "/transaction25/ti/195.php";
		include dirname(__FILE__) . "/transaction25/ti/199.php";
		include dirname(__FILE__) . "/transaction25/ti/191.php";
		include dirname(__FILE__) . "/transaction25/ti/194.php";
		include dirname(__FILE__) . "/transaction25/ti/198.php";
	?>
	</div>
	<div id="tab-t25-famille" class="tab-t25">
	<?php 
		include dirname(__FILE__) . "/transaction25/ti/140.php";
		include dirname(__FILE__) . "/transaction25/ti/141.php";
		include dirname(__FILE__) . "/transaction25/ti/110.php";
	?>
	</div>
	<div id="tab-t25-adresses" class="tab-t25">
	<?php 
		include dirname(__FILE__) . "/transaction25/ti/100.php";
		include dirname(__FILE__) . "/transaction25/ti/212.php";
		include dirname(__FILE__) . "/transaction25/ti/001.php";
		include dirname(__FILE__) . "/transaction25/ti/024.php";
		include dirname(__FILE__) . "/transaction25/ti/020.php";
		include dirname(__FILE__) . "/transaction25/ti/019.php";
		include dirname(__FILE__) . "/transaction25/ti/003.php";
		include dirname(__FILE__) . "/transaction25/ti/022.php";
		include dirname(__FILE__) . "/transaction25/ti/251.php";
	?>
	</div>
	<div id="tab-t25-professions" class="tab-t25">
	<?php 
	
	if(file_exists( dirname(__FILE__) . "/transaction25/ti/070.php"))
		include dirname(__FILE__) . "/transaction25/ti/070.php";
	?>
	</div>
	<div id="tab-t25-divers" class="tab-t25">
	<?php 
		include dirname(__FILE__) . "/transaction25/ti/005.php";
		include dirname(__FILE__) . "/transaction25/ti/028.php";
		include dirname(__FILE__) . "/transaction25/ti/207.php";
		include dirname(__FILE__) . "/transaction25/ti/210.php";
		include dirname(__FILE__) . "/transaction25/ti/202.php";
		include dirname(__FILE__) . "/transaction25/ti/205.php";
		include dirname(__FILE__) . "/transaction25/ti/192.php";
	?>
	</div>
	<div id="tab-t25-tous" class="tab-t25">
	<?php 
		for($i=0; $i<=254; $i++) {
			$filename = dirname(__FILE__) . "/transaction25/ti/" . str_pad($i, 3, '0', STR_PAD_LEFT) . ".php";
			
			if (file_exists($filename)) {
				include $filename;
			}
		}
	?>
	</div>
	
	<!-- <div id="tab-t25-raw" class="tab-t25"> </div> -->

</div>

<?php endif; ?>
