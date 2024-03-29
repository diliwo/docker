<?php

    class FPPARMEUROManager extends Manager{

        public function GetAllTables(){
        
             $sql = " SELECT  SSC_FPPARMEURO.NSEQ1,  
                                      SSC_FPPARMEURO.INFOR1
                                 FROM SSC_FPPARMEURO  
                                WHERE SSC_FPPARMEURO.INFOR1 IS NOT NULL
                                  AND NVL(SSC_FPPARMEURO.NSEQ1, 0) <> 0
                                  AND SSC_FPPARMEURO.NTABL1 = 0
                             ORDER BY SSC_FPPARMEURO.NSEQ1
                    ";
             
             try{
                
                $sth = $this->_db->prepare($sql);
                $sth->execute();
                $t_Ntable_Inti = $sth->fetchAll(PDO::FETCH_ASSOC);
                $Ntable_IntiList = array();
               
                foreach($t_Ntable_Inti as $Ntable_IntiData){

                    $Ntable_Inti = Factory::createObject('FPPARMEURO');
                    $Ntable_Inti->hydrate($Ntable_IntiData);
                    $Ntable_IntiList[]= $Ntable_Inti;

                }
               
                return $Ntable_IntiList;

            }
            catch(Exception $e) {
                   // echo ($e->getMessage());
                    echo ("<script>alert('Echec de la récupération de la liste des tables FPPARMEURO. ERROR SQL : ".$sth->errorInfo()[0]."  ".$sth->errorInfo()[1]."');</script>");
            } 
        }
        public function TestDataTable($Ntable){

            $sql = "    SELECT COUNT(*) AS CPT
                          FROM SSC_FPPARMEURO
                         WHERE SSC_FPPARMEURO.NTABL1 = :id_table
                    ";
             
             try{
                
                $sth = $this->_db->prepare($sql);
                $sth->bindvalue(":id_table", $Ntable, PDO::PARAM_INT);
                $sth->execute();
                $cpt = $sth->fetch(PDO::FETCH_ASSOC);
               
                if(!empty($cpt)){

                    if($cpt['CPT'] > 0){

                        $verifie = TRUE;
                    }
                    else{

                        $verifie = FALSE;
                    }                       
                }

                return $verifie; 

            }
            catch(Exception $e) {
                echo ("<script> alert('Exception : " .$e->getMessage()." '); </script>");
                echo ("<script> alert('Echec de la récupération des records de la table ".$Ntable.". ERROR SQL : ".$sth->errorInfo()[0]." ".$sth->errorInfo()[1]." '); </script>");
            } 
        }        
        public function GetAllRecordsByTable($Ntable){
            $sql = "    SELECT SSC_FPPARMEURO.*
                          FROM SSC_FPPARMEURO                           
                         WHERE SSC_FPPARMEURO.NTABL1 = :id_table
                      ORDER BY SSC_FPPARMEURO.NSEQ1
                    ";
             
             try{
                
                $sth = $this->_db->prepare($sql);
                $sth->bindvalue(":id_table", $Ntable, PDO::PARAM_INT);
                $sth->execute();
                $t_Ntable = $sth->fetchAll(PDO::FETCH_ASSOC);
                $Ntable_list = array();

                foreach($t_Ntable as $Ntable_data){

                    $Ntable_records = Factory::createObject('FPPARMEURO');
                    $Ntable_records->hydrate($Ntable_data);
                    $Ntable_list[] = $Ntable_records;
                    
                }
               
                return $Ntable_list;

            }
            catch(Exception $e) {
                   // echo ($e->getMessage());
                    echo ("<script>alert('Echec de la récupération de la liste des tables FPPARMEURO. ERROR SQL : ".$sth->errorInfo()[0]." ');</script>");
            }     
        }
        public function GetMaxNseq1ByTable($Ntable){

            $sql = "    SELECT MAX(SSC_FPPARMEURO.NSEQ1) AS MAX
                          FROM SSC_FPPARMEURO                           
                         WHERE SSC_FPPARMEURO.NTABL1 = :id_table
                   ";
             
             try{
                
                $sth = $this->_db->prepare($sql);
                $sth->bindvalue(":id_table", $Ntable, PDO::PARAM_INT);
                $sth->execute();
                $t_Nseq1 = $sth->fetch(PDO::FETCH_ASSOC);
                $Nseq1 = $t_Nseq1['MAX'];
                                
                return $Nseq1;

            }
            catch(Exception $e) {
                   // echo ($e->getMessage());
                    echo ("<script>alert('Echec de la récupération du Nseq1 Max de FPPARMEURO. ERROR SQL : ".$sth->errorInfo()[0]." ');</script>");
            }     
        }
        public function AddRecordsByObject($FPPARMEUROObject){
            $sql = " INSERT INTO SSC_FPPARMEURO (
                            SSC_FPPARMEURO.ntabl1,
                            SSC_FPPARMEURO.nseq1,
                            SSC_FPPARMEURO.mini11,
                            SSC_FPPARMEURO.maxi11,
                            SSC_FPPARMEURO.mini21,
                            SSC_FPPARMEURO.maxi21,
                            SSC_FPPARMEURO.mini31,
                            SSC_FPPARMEURO.maxi31,
                            SSC_FPPARMEURO.mini41,
                            SSC_FPPARMEURO.maxi41,
                            SSC_FPPARMEURO.mini51,
                            SSC_FPPARMEURO.maxi51,
                            SSC_FPPARMEURO.mini61,
                            SSC_FPPARMEURO.maxi61,
                            SSC_FPPARMEURO.mini71,
                            SSC_FPPARMEURO.maxi71,
                            SSC_FPPARMEURO.mini81,
                            SSC_FPPARMEURO.maxi81,
                            SSC_FPPARMEURO.mini91,
                            SSC_FPPARMEURO.maxi91,
                            SSC_FPPARMEURO.amin11,
                            SSC_FPPARMEURO.amax11,
                            SSC_FPPARMEURO.infor1    
                            )
                            VALUES
                            (
                            :ntabl1,
                            :nseq1,
                            :mini11,
                            :maxi11,
                            :mini21,
                            :maxi21,
                            :mini31,
                            :maxi31,
                            :mini41,
                            :maxi41,
                            :mini51,
                            :maxi51,
                            :mini61,
                            :maxi61,
                            :mini71,
                            :maxi71,
                            :mini81,
                            :maxi81,
                            :mini91,
                            :maxi91,
                            :amin11,
                            :amax11,
                            :infor1 
                            )   
                   ";
             
             try{
                
                $sth = $this->_db->prepare($sql);
                $sth->bindvalue(":ntabl1", $FPPARMEUROObject->ntabl1, PDO::PARAM_INT);
                $sth->bindvalue(":nseq1", $FPPARMEUROObject->nseq1, PDO::PARAM_INT);
                $sth->bindvalue(":mini11", $FPPARMEUROObject->mini11, PDO::PARAM_INT);
                $sth->bindvalue(":maxi11", $FPPARMEUROObject->maxi11, PDO::PARAM_INT);
                $sth->bindvalue(":mini21", $FPPARMEUROObject->mini21, PDO::PARAM_INT);
                $sth->bindvalue(":maxi21", $FPPARMEUROObject->maxi21, PDO::PARAM_INT);
                $sth->bindvalue(":mini31", $FPPARMEUROObject->mini31, PDO::PARAM_INT);
                $sth->bindvalue(":maxi31", $FPPARMEUROObject->maxi31, PDO::PARAM_INT);
                $sth->bindvalue(":mini41", $FPPARMEUROObject->mini41, PDO::PARAM_INT);
                $sth->bindvalue(":maxi41", $FPPARMEUROObject->maxi41, PDO::PARAM_INT);
                $sth->bindvalue(":mini51", $FPPARMEUROObject->mini51, PDO::PARAM_INT);
                $sth->bindvalue(":maxi51", $FPPARMEUROObject->maxi51, PDO::PARAM_INT);
                $sth->bindvalue(":mini61", $FPPARMEUROObject->mini61, PDO::PARAM_INT);
                $sth->bindvalue(":maxi61", $FPPARMEUROObject->maxi61, PDO::PARAM_INT);
                $sth->bindvalue(":mini71", $FPPARMEUROObject->mini71, PDO::PARAM_INT);
                $sth->bindvalue(":maxi71", $FPPARMEUROObject->maxi71, PDO::PARAM_INT);
                $sth->bindvalue(":mini81", $FPPARMEUROObject->mini81, PDO::PARAM_INT);
                $sth->bindvalue(":maxi81", $FPPARMEUROObject->maxi81, PDO::PARAM_INT);
                $sth->bindvalue(":mini91", $FPPARMEUROObject->mini91, PDO::PARAM_INT);
                $sth->bindvalue(":maxi91", $FPPARMEUROObject->maxi91, PDO::PARAM_INT);
                $sth->bindvalue(":amin11", $FPPARMEUROObject->amin11, PDO::PARAM_STR);
                $sth->bindvalue(":amax11", $FPPARMEUROObject->amax11, PDO::PARAM_STR);
                $sth->bindvalue(":infor1", $FPPARMEUROObject->infor1, PDO::PARAM_STR);
                $sth->execute();
               
                return true;
            }
            catch(Exception $e) {
                   // echo ($e->getMessage());
                    echo ("<script>alert('Echec lors de l\'ajout d\'un record dans FPPARMEURO. ERROR SQL : ".$sth->errorInfo()[0]." ".$sth->errorInfo()[1]." ');</script>");
            }     
        }
        public function UpdateRecordsByObject($FPPARMEUROObject){

            $sql = " UPDATE SSC_FPPARMEURO
                        SET SSC_FPPARMEURO.MINI11 = :mini11,
                            SSC_FPPARMEURO.MAXI11 = :maxi11,
                            SSC_FPPARMEURO.MINI21 = :mini21,
                            SSC_FPPARMEURO.MAXI21 = :maxi21,
                            SSC_FPPARMEURO.MINI31 = :mini31,
                            SSC_FPPARMEURO.MAXI31 = :maxi31,
                            SSC_FPPARMEURO.MINI41 = :mini41,
                            SSC_FPPARMEURO.MAXI41 = :maxi41,
                            SSC_FPPARMEURO.MINI51 = :mini51,
                            SSC_FPPARMEURO.MAXI51 = :maxi51,
                            SSC_FPPARMEURO.MINI61 = :mini61,
                            SSC_FPPARMEURO.MAXI61 = :maxi61,
                            SSC_FPPARMEURO.MINI71 = :mini71,
                            SSC_FPPARMEURO.MAXI71 = :maxi71,
                            SSC_FPPARMEURO.MINI81 = :mini81,
                            SSC_FPPARMEURO.MAXI81 = :maxi81,
                            SSC_FPPARMEURO.MINI91 = :mini91,
                            SSC_FPPARMEURO.MAXI91 = :maxi91,
                            SSC_FPPARMEURO.AMIN11 = :amin11,
                            SSC_FPPARMEURO.AMAX11 = :amax11,
                            SSC_FPPARMEURO.INFOR1 = :infor1
                      WHERE SSC_FPPARMEURO.NTABL1 = :ntabl1
                        AND SSC_FPPARMEURO.NSEQ1 = :nseq1
                   ";
             
             try{
                
                $sth = $this->_db->prepare($sql);
                $sth->bindvalue(":ntabl1", $FPPARMEUROObject->ntabl1, PDO::PARAM_INT);
                $sth->bindvalue(":nseq1", $FPPARMEUROObject->nseq1, PDO::PARAM_INT);
                $sth->bindvalue(":mini11", $FPPARMEUROObject->mini11, PDO::PARAM_INT);
                $sth->bindvalue(":maxi11", $FPPARMEUROObject->maxi11, PDO::PARAM_INT);
                $sth->bindvalue(":mini21", $FPPARMEUROObject->mini21, PDO::PARAM_INT);
                $sth->bindvalue(":maxi21", $FPPARMEUROObject->maxi21, PDO::PARAM_INT);
                $sth->bindvalue(":mini31", $FPPARMEUROObject->mini31, PDO::PARAM_INT);
                $sth->bindvalue(":maxi31", $FPPARMEUROObject->maxi31, PDO::PARAM_INT);
                $sth->bindvalue(":mini41", $FPPARMEUROObject->mini41, PDO::PARAM_INT);
                $sth->bindvalue(":maxi41", $FPPARMEUROObject->maxi41, PDO::PARAM_INT);
                $sth->bindvalue(":mini51", $FPPARMEUROObject->mini51, PDO::PARAM_INT);
                $sth->bindvalue(":maxi51", $FPPARMEUROObject->maxi51, PDO::PARAM_INT);
                $sth->bindvalue(":mini61", $FPPARMEUROObject->mini61, PDO::PARAM_INT);
                $sth->bindvalue(":maxi61", $FPPARMEUROObject->maxi61, PDO::PARAM_INT);
                $sth->bindvalue(":mini71", $FPPARMEUROObject->mini71, PDO::PARAM_INT);
                $sth->bindvalue(":maxi71", $FPPARMEUROObject->maxi71, PDO::PARAM_INT);
                $sth->bindvalue(":mini81", $FPPARMEUROObject->mini81, PDO::PARAM_INT);
                $sth->bindvalue(":maxi81", $FPPARMEUROObject->maxi81, PDO::PARAM_INT);
                $sth->bindvalue(":mini91", $FPPARMEUROObject->mini91, PDO::PARAM_INT);
                $sth->bindvalue(":maxi91", $FPPARMEUROObject->maxi91, PDO::PARAM_INT);
                $sth->bindvalue(":amin11", $FPPARMEUROObject->amin11, PDO::PARAM_STR);
                $sth->bindvalue(":amax11", $FPPARMEUROObject->amax11, PDO::PARAM_STR);
                $sth->bindvalue(":infor1", $FPPARMEUROObject->infor1, PDO::PARAM_STR);
                $sth->execute();
               
                return true;
            }
            catch(Exception $e) {
                   // echo ($e->getMessage());
                    echo ("<script>alert('Echec lors de la modification d\'un record dans FPPARMEURO. ERROR SQL : ".$sth->errorInfo()[0]." ".$sth->errorInfo()[1]." ');</script>");
            }     
        }
        public function DeleteRecordsByObject($FPPARMEUROObject){

            $sql = " DELETE FROM SSC_FPPARMEURO
                           WHERE SSC_FPPARMEURO.NTABL1 = :ntabl1
                             AND SSC_FPPARMEURO.NSEQ1 = :nseq1
                   ";
             
             try{
                
                $sth = $this->_db->prepare($sql);
                $sth->bindvalue(":ntabl1", $FPPARMEUROObject->ntabl1, PDO::PARAM_INT);
                $sth->bindvalue(":nseq1", $FPPARMEUROObject->nseq1, PDO::PARAM_INT);
                $sth->execute();
               
                return true;
            }
            catch(Exception $e) {
                   
                    echo ("<script>alert('Echec lors de la suppression du record dans FPPARMEURO. ERROR SQL : ".$sth->errorInfo()[0]." ".$sth->errorInfo()[1]." ');</script>");
            }     
        }
        public function GetNtable1Max(){

             $sql = "    SELECT MAX(SSC_FPPARMEURO.NSEQ1) AS MAX
                          FROM SSC_FPPARMEURO
                        WHERE SSC_FPPARMEURO.NTABL1 = 0
                   ";          
             try{
                
                $sth = $this->_db->prepare($sql);                
                $sth->execute();
                $t_Ntabl1 = $sth->fetch(PDO::FETCH_ASSOC);
                $Ntabl1 = $t_Ntabl1['MAX'];
                                
                return $Ntabl1;

            }
            catch(Exception $e) {

                    echo ("<script>alert('Echec de la récupération du Ntabl1 Max de FPPARMEURO. ERROR SQL : ".$sth->errorInfo()[0]." ".$sth->errorInfo()[1]."');</script>");
            }
        }
    }