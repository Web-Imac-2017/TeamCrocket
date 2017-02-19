
<?php

        public function GetLatLong(){
          $dlocation='Sidi bousaid, Tunisie';
          $address = $dlocation; // Google HQ
          $prepAddr = str_replace(' ','+',$address);
          $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
          $output= json_decode($geocode);
          $latitude = $output->results[0]->geometry->location->lat;
          $longitude = $output->results[0]->geometry->location->lng;
          echo 'l"adresse: '.$dlocation."\n";
          echo 'a pour latitude: '.$latitude."\n";
          echo 'et longitude: '.$longitude."\n";

            //$this-> ;
        }

?>
