<h1>Transaction 25</h1>

<?php if($res['error']): ?>

<p class="error"><?php echo $res['message']; ?></p>

<?php else: ?>

<p>Date de collecte : <?php echo DateTransaction25::format($res['data'][253]['data'][0]->Date); ?></p>
<p>Date de dernière mise-à-jour : <?php echo DateTransaction25::format($res['data'][254]['data'][0]->Date); ?></p>
<br />

<div id="flux_transaction25_tous">
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

</div>

<?php endif; ?>
