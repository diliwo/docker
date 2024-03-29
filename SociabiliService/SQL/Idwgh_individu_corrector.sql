/*
	Le scripy risque de ne pas fonctionner si un individu possède plusieurs tiers.
	Dans ce cas, les doublons devront être supprimés avant de reexécuter le script.
*/
update SSC_INDIVIDUS ind
set ind.ID_WGH = (
	select TIE.ID_WGH from
	    SSC_TIERS TIE
	WHERE TIE.ID_INDIVIDUS = ind.ID_INDIVIDUS)
WHERE ind.ID_WGH IS NULL;