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
		public function encrypt($inputString="", $initialKey="a,a,a", $plugboardString="") {
			if(trim($inputString) != "") {
				return $this->startEncryptionProcess($inputString, $initialKey, $plugboardString);
			}
		}
		private function startEncryptionProcess($inputString, $initialKey, $plugboardString) {
			if($this->isValidKey($initialKey)) {
				if(strlen($plugboardString)>=2 && $this->isValidPlugboardEntry($plugboardString)) {
					$this->setPlugBoard($plugboardString);
				}
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
		private function isValidPlugboardEntry($plugboardString) {
			return true;
		}
		private function setPlugBoard($plugboard) {
			$this->plugboard = explode(",",$plugboard);
		}
		private function encryptCharecter($inputCharecter) {
			$outputCharecter = $inputCharecter;
			if(in_array($inputCharecter, $this->rotor1, true)) {
				$outputCharecter = $this->transformOnPlugBoard($inputCharecter);
				
				$outputCharecter = $this->passThroughRotor1($outputCharecter);
				$outputCharecter = $this->passThroughRotor2($outputCharecter);
				$outputCharecter = $this->passThroughRotor3($outputCharecter);
				
				$outputCharecter = $this->passThroughReflector($outputCharecter);
				
				$outputCharecter = $this->passThroughRotor3($outputCharecter);
				$outputCharecter = $this->passThroughRotor2($outputCharecter);
				$outputCharecter = $this->passThroughRotor1($outputCharecter);

				$outputCharecter = $this->transformOnPlugBoard($inputCharecter);
				
			}
			$this->rotateRotors();
			return $outputCharecter;
		}
		private function passThroughReflector($inputcharecter) {
			$posionOfInputCharecter = array_search($inputcharecter, $this->rotor1);
			return $this->rotor1[51-$posionOfInputCharecter];
		}
		private function getSingleDigitAfterSummation($number) {
			$numberString = (string)$number;
			if(strlen($numberString) == 1) {
				return $number;
			} else {
				$outputNumber = 1;
				for($index=0; $index<strlen($numberString); $index++) {
					$outputNumber *= intval($numberString[$index]);
				}
				return $this->getSingleDigitAfterSummation($outputNumber);
			}
		}
		private function getCharecterAfterSubstitutionOfGivenPosition($position) {
			$roundOfNumber = round((count($this->rotor1)-1)/($position));
			return $this->rotor1[$roundOfNumber];
		}
		private function passThroughRotor1($inputCharecter) {
			$positionOfRotor1Value = array_search($this->rotor1Value, $this->rotor1, true)+1;
			$positionOfTheInputCharecterInRotor1 = array_search($inputCharecter, $this->rotor1)+1;
			$totalPosition = $positionOfRotor1Value + $positionOfTheInputCharecterInRotor1;
			$singleDigitPosition = $this->getSingleDigitAfterSummation($totalPosition);
			$charecter = $this->getCharecterAfterSubstitutionOfGivenPosition($singleDigitPosition);
			return $charecter;
		}
		private function passThroughRotor2($inputCharecter) {
			$positionOfRotor2Value = array_search($this->rotor2Value, $this->rotor2, true)+1;
			$positionOfTheInputCharecterInRotor2 = array_search($inputCharecter, $this->rotor1)+1;
			$totalPosition = $positionOfRotor2Value + $positionOfTheInputCharecterInRotor2;
			$singleDigitPosition = $this->getSingleDigitAfterSummation($totalPosition);
			$charecter = $this->getCharecterAfterSubstitutionOfGivenPosition($singleDigitPosition);
			return $charecter;
		}
		private function passThroughRotor3($inputCharecter) {
			$positionOfRotor3Value = array_search($this->rotor3Value, $this->rotor3, true)+1;
			$positionOfTheInputCharecterInRotor3 = array_search($inputCharecter, $this->rotor1)+1;
			$totalPosition = $positionOfRotor3Value + $positionOfTheInputCharecterInRotor3;
			$singleDigitPosition = $this->getSingleDigitAfterSummation($totalPosition);
			$charecter = $this->getCharecterAfterSubstitutionOfGivenPosition($singleDigitPosition);
			return $charecter;
		}
		private function transformOnPlugBoard($inputCharecter) {
			foreach($this->plugboard as $plugboardEntry) {
				if($plugboardEntry[0]==$inputCharecter) {
					return $plugboardEntry[1];
				}
				if($plugboardEntry[1]==$inputCharecter) {
					return $plugboardEntry[0];	
				}
			}
			return $inputCharecter;
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
					if(!in_array($charecter, $this->rotor1, true)) {
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
					case 3:
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