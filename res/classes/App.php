<?php

/**
 * Description of App
 *
 * @author leos
 */
class App {

    public $vin;
    private $_cache;

    const CACHE_MAX_TIME = 1; // 1 hodina

    public function __construct($vin) {
        $this->vin = trim(strtoupper($vin));
        $this->vin = str_replace("O", "0", $this->vin); // Zamenime O za nulu
        $this->vin = str_replace(" ", "", $this->vin); //
    }

    public function checkVin() {
        if (!$this->vin) {
            return array(
                "result" => false,
                "message" => "Nebylo zadáno VIN",
            );
        } elseif (strlen($this->vin) == 17) {
            if (strpos($this->vin, "I") === false && strpos($this->vin, "Q") === false) {
                return array(
                    "result" => true,
                    "message" => "",
                );
            } else {
                return array(
                    "result" => false,
                    "message" => "VIN nesmí obsahovat znaky I, Q.",
                );
            }
        } elseif (strlen($this->vin) > 17) { // delka VIN neni 17 znaku
            return array(
                "result" => false,
                "message" => "VIN nesmí mít více než 17 znaků"
            );
        } else { // delka VIN je mene nez 17 znaku, muze se jednat o starsi VIN a je treba potvrdit
            if (strpos($this->vin, "I") === false && strpos($this->vin, "Q") === false) {
                return array(
                    "result" => false,
                    "message" => "VIN nesmí mít méně než 17 znaků"
                );
//				return array(
//					"result" => "confirm",
//					"message" => "Standardní VIN má vždy 17 znaků. <br/> Kratší řetězce jsou používány vyjímečně pouze pro některé pracovní a stavební stroje, traktory apod., nebo pro vozidla vyrobená před rokem 1986.<br/><br/>Jedná se opravdu o vyjímku kdy není k dispozici standardní VIN ?"
//				);
            } else {
                return array(
                    "result" => false,
                    "message" => "VIN nesmí obsahovat znaky I, Q.",
                );
            }
        }
    }

}
