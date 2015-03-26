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
		public function encrypt($inputString="") {
			if(trim($inputString) != "") {
				$this->startEncryptionProcess($inputString);
			}
		}
		private function startEncryptionProcess($inputString, $initialKey) {
			if($this->isValidKey($initialKey)) {
				setInitialKey();
				$outputString = "";
				for($index=0; $index<strlen($inputString); $index++) {
					
				}
			}
		}
		private function isValidKey($key) {
			$keyArray = explode(",",$key);
		}
		private function setInitialKey() {
			$randomNumbers = $this->getRandomNumber();
			$this->setRotors($randomNumbers);
		}
		private function setRotors($randomNumbers) {
			$index = 1;
			foreach($randomNumbers as $randomNumber) {
				switch($index) {
					case 1:
						$this->rotor1Value = $this->rotor1[$randomNumber];
					break;
					case 2:
						$this->rotor1Value = $this->rotor1[$randomNumber];
					break;
					case 3
						$this->rotor1Value = $this->rotor1[$randomNumber];
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
		private function getRandomNumber() {
			return array(5, 2, 3);
		}



	}
?>	