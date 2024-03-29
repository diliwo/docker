/**
 * Classe RegistreNational.js
 * 
 * @author: Arnaud Borgniez
 */

var RegistreNational = {
	valider: function(rn) {
		var modulo;

		var millenaire; var annee; var mois; var jour;
		var sexe;
		var verif;
		
		if (rn.length==11) {
			annee = rn.substr(0, 2);
			mois = rn.substr(2, 2);
			jour = rn.substr(4, 2);
			sexe = rn.substr(6, 3);

			modulo = annee + mois + jour + sexe;
			verif = rn.substr(9, 2);

			if(97 - (modulo % 97) != verif) {
				return RegistreNational.valider('2' + rn);

			} else {
				return true;

			}

		} else if(rn.length==12) {
			millenaire = rn.charAt(0);
			annee = rn.substr(1, 2);
			mois = rn.substr(3, 2);
			jour = rn.substr(5, 2);
			sexe = rn.substr(7, 3);

			if (millenaire == '2') {
				modulo = '2' + annee + mois + jour + sexe;

			} else {
				modulo = annee + mois + jour + sexe;

			}
			verif = rn.substr(10, 2);

			if(97 - (modulo % 97) != verif) {
				return false;

			} else {
				return true;

			}

		} else {
			return false;

		}
	}
}
