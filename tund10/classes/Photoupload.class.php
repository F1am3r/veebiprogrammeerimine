<?php
	class Photoupload {
		#private $testPrivate;
		#public $testPublic;
		private $tempFile;
		private $imageFileType;
		private $myTempImage;
		private $myImage;
		
		
		function __construct($tempFile, $imageFileType){
			#$this->testPublic = " Täitsa avalik asi.";
			#echo $this->testPrivate = $x;	
			$this->tempFile = $tempFile;
			$this->imageFileType = $imageFileType;
		}
		
		private function createImage(){
			if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
				$this->myTempImage = imagecreatefromjpeg($this->tempFile);
			}
			if($this->imageFileType == "png"){
				$this->myTempImage = imagecreatefrompng($this->tempFile);
			}
			if($this->imageFileType == "gif"){
				$this->myTempImage = imagecreatefromgif($this->tempFile);
			}
		}
		
		public function resizePhoto($maxWidth, $maxHeight){
			$this->createImage();
			//teeme kindlaks preaguse suuruse
			$imageWidth = imagesx($this->myTempImage);
			$imageHeight = imagesy($this->myTempImage);
			//arvutan suuruse suhte
			if($imageWidth > $imageHeight) {
				$sizeRatio = $imageWidth/$maxWidth;
			} else {
				$sizeRatio = $imageHeight/$maxHeight;
			}
			//tekitame uue, sobiva suurusega pildi
			$this->myImage = $this->resizeImage($this->myTempImage, $imageWidth, $imageHeight, round($imageWidth/$sizeRatio), round($imageHeight/$sizeRatio));
		}
		
		
		private	function resizeImage($image, $origW, $origH, $w, $h){
			$newImage = imagecreatetruecolor($w, $h);
			imagesavealpha($newImage, true);
			$trans_colour = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
			imagefill($newImage, 0, 0, $trans_colour);
			//kuhu, kust, mis kordinaatidele x ja y, kust kordinaatidelt x ja y, uued w ja h ning originaal w ja h.
			imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $origW, $origH);
			return $newImage;
		}
		
		//lisan vesimärgi
		public function addWatermark($watermark,$marginHor, $marginVer){
			$stamp = imagecreatefrompng($watermark);
			$stampWidth = imagesx($stamp);
			$stampHeight = imagesy($stamp);
			$stampX = imagesx($this->myImage) - $stampWidth - $marginHor;
			$stampY = imagesy($this->myImage) - $stampHeight - $marginVer;
			imagecopy($this->myImage, $stamp, $stampX, $stampY, 0, 0, $stampWidth, $stampHeight);
		}
		
		//lisan teksti watermarkile
		public function addTextWatermark($text){
			$textColor = imagecolorallocatealpha($this->myImage, 255,255,255,60);
			imagettftext($this->myImage, 20, -45, 10, 25, $textColor, "../../graphics/VIBES.ttf", $text);
		}
		
			
		//salvestame pildi jpg
		public function savePhoto($directory, $fileName){
			$target_file = $directory .$fileName;
			if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
				if(imagejpeg($this->myImage, $target_file, 90)){
					$notice = "Fail on üles laetud.";
				} else {
					$notice = "Vabandust, kuid faili üleslaadimisel tekkis viga.";
				}				
			}
			//png salvestamine
			if($this->imageFileType == "png"){
				if(imagepng($this->myImage, $target_file)){
					$notice = "Fail on üles laetud.";
				} else {
					$notice .= "Vabandust, kuid faili üleslaadimisel tekkis viga.";
				}				
			}
			//gif salvestamine
			if($this->imageFileType == "gif"){
				if(imagegif($this->myImage, $target_file)){
					$notice = "Fail on üles laetud.";
				} else {
					$notice .= "Vabandust, kuid faili üleslaadimisel tekkis viga.";
				}				
			}
			$this->clearImages();
			return $notice;
		}
		
		//salvestame originaali
		public function saveOriginal(){
			$target_dir = $directory.$filename;
			if(move_uploaded_file($this->tempFile, $target_file)) {
				$notice = "OG Fail on üles laetud.";
			} else {
				$notice .= "Vabandust, kuid faili üleslaadimisel tekkis viga.";
			}
			return $notice;
		}
		
		
		//vabastan mälu
		public function clearImages(){
			imagedestroy($this->myTempImage);
			imagedestroy($this->myImage);

		}
	}//class lõppeb. Selle järele pole ilus muud koodi kirjutada, et oleks puhas class dokument.
?>

