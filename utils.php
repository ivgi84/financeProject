<?php
class Utils{

   static function getJson($url) {

        $cacheFile = 'cache' . DIRECTORY_SEPARATOR . md5($url);

        if (file_exists($cacheFile)) {
            $fh = fopen($cacheFile, 'r');
            $cacheTime = trim(fgets($fh));

            if ($cacheTime > strtotime('-30 minutes')) {
                return fread($fh,filesize($cacheFile));
            }

            fclose($fh);
            unlink($cacheFile);
        }

        $json = file_get_contents($url);

        $fh = fopen($cacheFile, 'w');
        fwrite($fh, time() . "\n");
        fwrite($fh, $json);
        fclose($fh);

        return $json;
    }


    static function convertToNisNew ($currenyCode, $sum=1){

        $xml=Utils::getJson('http://www.boi.org.il/currency.xml');
        $data= new SimpleXMLElement($xml,NULL,true);

        $info= $data->xpath("CURRENCY[CURRENCYCODE='$currenyCode']");

        foreach($info as $i){
            $rate=$i->RATE;
        }
        $sumInNis=floatval($sum) * floatval($rate);
        return $sumInNis;
    }


    static function convertToNis ($currenyCode, $sum=1){

        $data= new SimpleXMLElement('http://www.boi.org.il/currency.xml',NULL,true);
        $info= $data->xpath("CURRENCY[CURRENCYCODE='$currenyCode']");

        foreach($info as $i){
            $rate=$i->RATE;
        }
        $sumInNis=floatval($sum) * floatval($rate);
        return $sumInNis;
    }

}




//$sum=Utils::convertToNis("USD",15);



