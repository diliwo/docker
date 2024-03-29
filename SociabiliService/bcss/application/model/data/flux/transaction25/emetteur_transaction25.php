<?php

class EmetteurTransaction25
{
	public static function format($emetteur)
	{
		$emetteurFormate = "";
		
		if (isset($emetteur->Place)) {
			$emetteurFormate .= $emetteur->Place->Label;
		} elseif (isset($emetteur->Province)) {
			$emetteurFormate .= $emetteur->Province->Label;
		} elseif (isset($emetteur->PosteDiplomatique)) {
			$emetteurFormate .= $emetteur->PosteDiplomatique->Label;
		}
		
		return $emetteurFormate;
	}
}