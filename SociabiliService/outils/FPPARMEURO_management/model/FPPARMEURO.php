<?php

    class FPPARMEURO{

        protected $ntabl1;
        protected $nseq1;
        protected $mini11;
        protected $maxi11;
        protected $mini21;
        protected $maxi21;
        protected $mini31;
        protected $maxi31;
        protected $mini41;
        protected $maxi41;
        protected $mini51;
        protected $maxi51;
        protected $mini61;
        protected $maxi61;
        protected $mini71;
        protected $maxi71;
        protected $mini81;
        protected $maxi81;
        protected $mini91;
        protected $maxi91;
        protected $amin11;
        protected $amax11;
        protected $infor1;


        public function _construct($ntabl1 = null, $nseq1 = null, $mini11 = null, $maxi11 = null, $mini21 = null, $maxi21 = null, $mini31 = null,
                                   $maxi31 = null, $mini41 = null, $maxi41 = null, $mini51 = null, $maxi51 = null, $mini61 = null, $maxi61 = null,
                                   $mini71 = null, $maxi71 = null, $mini81 = null, $maxi81 = null, $mini91 = null, $maxi91 = null, $amin11 = null, 
                                   $amax11 = null, $infor1 = null ){

            $this->ntabl1 = $ntabl1;
            $this->nseq1 = $nseq1;
            $this->mini11 = $mini11;
            $this->maxi11 = $maxi11;
            $this->mini21 = $mini21;
            $this->maxi21 = $maxi21;
            $this->mini31 = $mini31;
            $this->maxi31 = $maxi31;
            $this->mini41 = $mini41;
            $this->maxi41 = $maxi41;
            $this->mini51 = $mini51;
            $this->maxi51 = $maxi51;
            $this->mini61 = $mini61;
            $this->maxi61 = $maxi61;
            $this->mini71 = $mini71;
            $this->maxi71 = $maxi71;
            $this->mini81 = $mini81;
            $this->maxi81 = $maxi81;
            $this->mini91 = $mini91;
            $this->maxi91 = $maxi91;
            $this->amin11 = $amin11;
            $this->amax11 = $amax11;
            $this->infor1 = $infor1;
        }
        public function __set($att, $value){
            
            $this->$att = $value;
        }
        public function __get($name_att){

            if (isset($this->$name_att)){
				  return $this->$name_att;
			}
			else{
				
			}

        }
        public function hydrate(array $tab_att){
            
            foreach ($tab_att as $att => $value){
			  
              $att = strtolower($att);
			 
             if($value === "" && ($att !== "amin11" && $att !== "amax11" && $att !== "infor1" )){

                 $value = 0;
             }
             
             $this->$att = $value;

		    }

        }
        public function get_all_att(){

            $res = array();
			foreach($this as $att => $value){
				$res[$att] = $value;
			}
			return $res;
        } 
    }

?>