<?php

require_once 'date_transaction25.php';

class LieuTransaction25
{
	public static function format($lieu)
	{
		$lieuFormate = "";
		
		// Place
		$lieuFormate .= $lieu->Place->Label;
		// Pays
		if (isset($lieu->Country)) {
			$lieuFormate .= " (" . $lieu->Country->Label .")";
		}
		
		return $lieuFormate;
	}
	
	public static function formatEtatCivil($lieu)
	{
        
		// Place1
		$lieuFormate = (isset($lieu->Place1->Label) ? $lieu->Place1->Label : NULL );  ;
		// Place2
		if (isset($lieu->Place2))
			$lieuFormate .= " - " . $lieu->Place2->Graphic;
		if (isset($lieu->Place2->Country))
			$lieuFormate .= " (" . $lieu->Place2->Country->Label . ")";
		// Place3
		if (isset($lieu->Place3->BelgianJudgement)) {
			$lieuFormate .= " - jugement belge de " . $lieu->Place3->BelgianJudgement->Tribunal->Label . " (le " . DateTransaction25::format($lieu->Place3->BelgianJudgement->Date) . " à " . $lieu->Place3->BelgianJudgement->Place->Label . ")";
		} elseif (isset($lieu->Place3->ForeignJudgement)) {
			$lieuFormate .= " - jugement étranger de " . $lieu->Place3->ForeignJudgement->Place->Label;
		}
		if (isset($lieu->Place3->Transcription)) {
			$lieuFormate .= ", transcrit le " . DateTransaction25::format($lieu->Place3->Transcription->Date) . " à " . $lieu->Place3->Transcription->Place->Label;
		}
	
		return $lieuFormate;
	}
}