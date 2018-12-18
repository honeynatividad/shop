<?php
class ModelBosslabelproductsBossimage extends Model {
	public function getLabel($label_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "boss_label WHERE label_id = '" . (int)$label_id . "'");
		
		return $query->row;
	}
	
	public function getLabelProduct($product_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "boss_product_label WHERE 	product_id = '" . (int)$product_id . "'");
		
		return $query->row;		
	}
	
	public function checkLabel($product_id){
		$label = $this->getLabelProduct($product_id);
		if($label){
			if($label['top_left'] != 0){
				$image = $this->getLabel($label['top_left']);
				if($image['image'] != 'no_image.jpg'){	return 1; } 
			}
			if($label['top_right'] != 0){
				$image = $this->getLabel($label['top_right']);
				if($image['image'] != 'no_image.jpg'){	return 1; } 
			}
			if($label['center'] != 0){
				$image = $this->getLabel($label['center']);
				if($image['image'] != 'no_image.jpg'){	return 1; } 
			}
			if($label['bottom_left'] != 0){
				$image = $this->getLabel($label['bottom_left']);
				if($image['image'] != 'no_image.jpg'){	return 1; } 
			}
			if($label['bottom_right'] != 0){
				$image = $this->getLabel($label['bottom_right']);
				if($image['image'] != 'no_image.jpg'){	return 1; } 
			}
		}
		return 0;
	}

	public function create($image) {
		if (file_exists($image)) {
			$info = getimagesize($image);
			if ($info['mime'] == 'image/gif') {
				return imagecreatefromgif($image);
			} elseif ($info['mime'] == 'image/png') {
				return imagecreatefrompng($image);
			} elseif ($info['mime'] == 'image/jpeg') {
				return imagecreatefromjpeg($image);
			}
		}else{
			exit('Error: Could not load image ' . $image . '!');
		}
    }
	
	public function save($src, $des, $quality = 90) {
		$info = pathinfo($des);
		$extension = strtolower($info['extension']);
		if (is_resource($src)) {
			if ($extension == 'jpeg' || $extension == 'jpg') {
				imagejpeg($src, $des, $quality);
			} elseif($extension == 'png') {
				imagepng($src, $des);
			} elseif($extension == 'gif') {
				imagegif($src, $des);
			}
		}
    }	    
	
    public function resize($src, &$image, $width = 0, $height = 0) {
		$info = getimagesize($src);
		if (!$info[0] || !$info[1]) {
			return;
		}

		$xpos = 0;
		$ypos = 0;

		$scale = min($width / $info[0], $height / $info[1]);
		
		if ($scale == 1 && $info['mime'] != 'image/png') {
			return;
		}
		
		$new_width = (int)($info[0] * $scale);
		$new_height = (int)($info[1] * $scale);			
    	$xpos = (int)(($width - $new_width) / 2);
   		$ypos = (int)(($height - $new_height) / 2);
        		        
       	$image_old = $image;
        $image = imagecreatetruecolor($width, $height);
			
		if (isset($info['mime']) && $info['mime'] == 'image/png') {		
			//imagealphablending($image, false);
			//imagesavealpha($image, true);
			$background = imagecolorallocatealpha($image, 255, 255, 255, 0);
			imagecolortransparent($image, $background);
		} else {
			$background = imagecolorallocate($image, 255, 255, 255);
		}
		
		imagefilledrectangle($image, 0, 0, $width, $height, $background);
	
        imagecopyresampled($image, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $info[0], $info[1]);
        imagedestroy($image_old);
    }

	public function label_resize($filename, $width, $height, $product_id) {
		if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
			return;
		}
		$info = pathinfo($filename);
		$extension = $info['extension'];

		$old_image = $filename;
		$new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '-label.' . $extension;
		
		$path = '';
		
		$directories = explode('/', dirname(str_replace('../', '', $new_image)));
		
		foreach ($directories as $directory) {
			$path = $path . '/' . $directory;
			
			if (!file_exists(DIR_IMAGE . $path)) {
				@mkdir(DIR_IMAGE . $path, 0777);
			}		
		}
		$image = $this->create(DIR_IMAGE .$old_image); 
		$this->resize(DIR_IMAGE .$old_image, $image, $width, $height);
		
		$photoFrame = imagecreatetruecolor($width,$height);
		imagecopyresampled($photoFrame, $image, 0, 0, 0, 0, $width, $height, $width, $height); 

		$label = $this->getLabelProduct($product_id);
		if($label['top_left']){
			$logo = $this->getLabel($label['top_left']);
			if($logo['image'] != 'no_image.jpg' && file_exists("image/".$logo['image'])){
				$label1 = $this->create("image/".$logo['image']); 
				$labelW = imagesx($label1); 
				$labelH = imagesy($label1);
				$dest_x = 0;
				$dest_y = 0;
				imagecopy($photoFrame, $label1, $dest_x, $dest_y, 0, 0, $labelW, $labelH); 
				ImageDestroy ($label1);
			}
		}
		if($label['top_right']){
			$logo = $this->getLabel($label['top_right']);
			if($logo['image'] != 'no_image.jpg' && file_exists("image/".$logo['image'])){
				$label2 = $this->create("image/".$logo['image']); 
				$labelW = imagesx($label2); 
				$labelH = imagesy($label2);
				$dest_x = $width - $labelW ;
				$dest_y = 0;
				imagecopy($photoFrame, $label2, $dest_x, $dest_y, 0, 0, $labelW, $labelH); 
				ImageDestroy ($label2);
			}
		}
		if($label['center']){
			$logo = $this->getLabel($label['center']);
			if($logo['image'] != 'no_image.jpg' && file_exists("image/".$logo['image'])){
				$label3 = $this->create("image/".$logo['image']); 
				$labelW = imagesx($label3); 
				$labelH = imagesy($label3);
				$dest_x = $width/2 - $labelW/2 ;
				$dest_y = $height/2 - $labelH/2;
				imagecopy($photoFrame, $label3, $dest_x, $dest_y, 0, 0, $labelW, $labelH); 
				ImageDestroy ($label3);
			}
		}
		if($label['bottom_left']){
			$logo = $this->getLabel($label['bottom_left']);
			if($logo['image'] != 'no_image.jpg' && file_exists("image/".$logo['image'])){
				$label4 = $this->create("image/".$logo['image']); 
				$labelW = imagesx($label4); 
				$labelH = imagesy($label4);
				$dest_x = 0;
				$dest_y = $height - $labelH;
				imagecopy($photoFrame, $label4, $dest_x, $dest_y, 0, 0, $labelW, $labelH); 
				ImageDestroy ($label4);
			}
		}
		if($label['bottom_right']){
			$logo = $this->getLabel($label['bottom_right']);
			if($logo['image'] != 'no_image.jpg' && file_exists("image/".$logo['image'])){
				$label5 = $this->create("image/".$logo['image']); 
				$labelW = imagesx($label5); 
				$labelH = imagesy($label5);
				$dest_x = $width - $labelW;
				$dest_y = $height - $labelH;
				imagecopy($photoFrame, $label5, $dest_x, $dest_y, 0, 0, $labelW, $labelH); 
				ImageDestroy ($label5);
			}
		}
		$this->save($photoFrame, DIR_IMAGE . $new_image);
	
		ImageDestroy ($image);
		ImageDestroy ($photoFrame);

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			return $this->config->get('config_ssl') . 'image/' . $new_image;
		} else {
			return $this->config->get('config_url') . 'image/' . $new_image;
		}		
	}
}
?>