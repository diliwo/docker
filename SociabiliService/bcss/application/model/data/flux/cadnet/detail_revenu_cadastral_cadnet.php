<?php

class DetailRevenuCadastralCadnet
{
	public static function format($detailActif)
	{
		$detailActifFormate = "";
		
		if (isset($detailActif->assetNature)) {
			$detailActifFormate .= $detailActif->assetNature;
			
		} else {
			$detailActifFormate .= "BIEN IMMOBILIER INCONNU";
		}
		
		if (isset($detailActif->landRegisterIncomeAmount)) {
			$detailActifFormate .= " - montant cadastral de " . ((int) $detailActif->landRegisterIncomeAmount);
			
		}
		
		if (isset($detailActif->landRegisterIncomeCode)) {
			$detailActifFormate .= " (code: " . ((int) $detailActif->landRegisterIncomeCode) .")";
			
		}
		
		if (isset($detailActif->surface)) {
			$detailActifFormate .= " - superficie de " . ((int) $detailActif->surface) . " m²";
			
		}
		
		return $detailActifFormate;
	}
}