<?php
    require_once("../config.php");
    class Factory {
       
        public static function ConnectionDB(){
            
            global $_config;           
               
            try {
                    $db = new PDO ($_config["db"]["oracle"]["dsn"], $_config["db"]["oracle"]["username"], $_config["db"]["oracle"]["password"]);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (Exception $e) {
                    echo 'Échec lors de la connexion : ' . $e->getMessage();
            }
            return $db;
        }
        public static function createObject($className){
            
            switch ($className){
                case 'FPPARMEURO':
                    require_once("FPPARMEURO.php");
                    $object = new FPPARMEURO;
                    break;
                default:
                    throw new Exception ('Type d\'objet inconnu');
            }
            return $object;

        }
        public static function createManager($ManagerName){ 

            require_once("Manager.php");

            switch ($ManagerName){
                case 'FPPARMEUROManager':
                    require_once("FPPARMEUROManager.php");
                    $manager = new FPPARMEUROManager;
                    break;                
                default:
                    throw new Exception ('Type de manager inconnu');
            }
            return $manager;

        }
    }

?>