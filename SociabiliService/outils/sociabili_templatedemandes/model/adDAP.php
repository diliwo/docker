<?php


	class AdDAP
    {
        public static function isValide($log,$mdp)
        {
             define('AD_ACCOUNT_SUFFIX', '@cpas.intra');
             define('AD_BASE_DN', 'DC=cpas,DC=intra');
             define('AD_DOMAIN_CONTROLLER', 'cpas.intra');
             define('AD_ADMIN_USERNAME', 'ldap.query');
             define('AD_ADMIN_PASSWORD', 'Clpdql');

              $options = array(
            'account_suffix' => AD_ACCOUNT_SUFFIX,
            'base_dn' => AD_BASE_DN,
            'domain_controllers' => array(AD_DOMAIN_CONTROLLER),
            'admin_username' => AD_ADMIN_USERNAME,
            'admin_password' => AD_ADMIN_PASSWORD
              );

              $adldap = new adLDAP($options);
              
              $authUser = $adldap->user()->authenticate($log, $mdp);
              if ($authUser == true) {
                //echo "User authenticated successfully";
                
                return true;
              }
              else {
                // getLastError is not needed, but may be helpful for finding out why:
                //echo $adldap->getLastError();
               // echo "User authentication unsuccessful";
                return false;
              }   
        }

		public static function hasAccess($log,$mdp)	
		{
			define('AD_ACCOUNT_SUFFIX', '@cpas.intra');
             define('AD_BASE_DN', 'DC=cpas,DC=intra');
             define('AD_DOMAIN_CONTROLLER', 'cpas.intra');
             define('AD_ADMIN_USERNAME', 'ldap.query');
             define('AD_ADMIN_PASSWORD', 'Clpdql');

              $options = array(
            'account_suffix' => AD_ACCOUNT_SUFFIX,
            'base_dn' => AD_BASE_DN,
            'domain_controllers' => array(AD_DOMAIN_CONTROLLER),
            'admin_username' => AD_ADMIN_USERNAME,
            'admin_password' => AD_ADMIN_PASSWORD
              );

              $adldap = new adLDAP($options);
              
              $authUser = $adldap->user()->authenticate($log, $mdp);
              if ($authUser == true) 
			  {				
				$result = $adldap->user()->groups($log,false);
				 
				if(in_array("GG_SSCTemplate",$result))
				{
					return true;
				}
				else
				{
					return false;
				}
                
              }
              else {
                // getLastError is not needed, but may be helpful for finding out why:
                //echo $adldap->getLastError();
               // echo "User authentication unsuccessful";
                return false;
              }   
		}
    }
?>