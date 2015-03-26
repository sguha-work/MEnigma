<?php 
class MEnigma {
		private $rotor1, $rotor1Value;
		private $rotor2, $rotor2Value;
		private $rotor3, $rotor3Value;
		private $reflector;
		private $plugboard;
		private $charecters;
		private $initialKey;
		public function __construct() {
			$this->charecters = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z','A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
			$this->rotor1 = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z','A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
			$this->rotor2 = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z','A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
			$this->rotor3 = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z','A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
			$this->plugboard = array('ab', 'cd', 'ef', 'gh', 'ij', 'kl', 'mn', 'op', 'qr', 'st', 'uv', 'wx', 'yz', 'AB', 'CD', 'EF', 'GH', 'IJ', 'KL', 'MN', 'OP', 'QR', 'ST', 'UV', 'WX', 'YZ');
			$this->initialKey = "";
		}
		public function encrypt($inputString="", $initialKey="a,a,a") {
			if(trim($inputString) != "") {
				return $this->startEncryptionProcess($inputString, $initialKey);
			}
		}
		private function startEncryptionProcess($inputString, $initialKey) {
			if($this->isValidKey($initialKey)) {
				$this->setRotors($initialKey);		
				$outputString = "";
				for($index=0; $index<strlen($inputString); $index++) {
					$outputString .= $this->encryptCharecter($inputString[$index]);
				}
				return $outputString;
			} else {
				echo "Provided key is invalid key mast have 3 charecters between a-z and A-Z and they mast be comma separeted";die();
			}
		}
		private function encryptCharecter($inputCharecter) {
			
		}
		private function isValidKey($key) {
			$keyArray = explode(",",$key);
			if(count($keyArray) != 3) {
				return false;
			}
			foreach($keyArray as $charecter) {
				if(strlen($charecter) != 1) {
					return false;
				} else {
					if(!array_search($charecter, $this->rotor1)) {
						return false;
					}
				}
			}
			return true;
		}
		
		private function setRotors($initialKey) {
			$index = 1;
			$keyArray = explode(",", $initialKey);
			foreach($keyArray as $charecter) {
				switch($index) {
					case 1:
						$this->rotor1Value = $charecter;
					break;
					case 2:
						$this->rotor2Value = $charecter;
					break;
					case 3
						$this->rotor3Value = $charecter;
					break;
				}
				$index += 1;
			}
		}
		private function rotateRotors() { // this function takes the responsibility to rotate the rotors
			$this->rotateRotor1();
			if(strtolower($this->rotor1Value) == "w") {
				$this->rotateRotor2();
				if(strtolower($this->rotor1Value) == "f") {
					$this->rotateRotor3();
				}
			}
		}
		private function rotateRotor1() {
			$indexOfRotor1Value = array_search($this->rotor1Value, $this->rotor1, true);
			if($indexOfRotor1Value == 51) {
				$indexOfRotor1Value = 0;
			} else {
				$indexOfRotor1Value += 1;
			}
			$this->rotor1Value = $this->rotor1[$indexOfRotor1Value];
		}
		private function rotateRotor2() {
			$indexOfRotor2Value = array_search($this->rotor2Value, $this->rotor2, true);
			if($indexOfRotor2Value == 51) {
				$indexOfRotor2Value = 0;
			} else {
				$indexOfRotor2Value += 1;
			}
			$this->rotor2Value = $this->rotor2[$indexOfRotor2Value];	
		}
		private function rotateRotor3() {
			$indexOfRotor3Value = array_search($this->rotor3Value, $this->rotor3, true);
			if($indexOfRotor3Value == 51) {
				$indexOfRotor3Value = 0;
			} else {
				$indexOfRotor3Value += 1;
			}
			$this->rotor3Value = $this->rotor3[$indexOfRotor3Value];		
		}

	}
?>	