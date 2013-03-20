<?php
class ImagePlugin
{
	public static function resize($img,$width,$height,$crop)
	{
		$redirect = true;
		if(file_exists($img)):
			$original = $img;
			$crop = !$crop ? false : $crop;
			$crop = $crop == 1 ? true : $crop;
			
			$width = is_int(1*$width) && $width ? 1*$width : null;
			$height = is_int(1*$height) && $height? 1*$height : null;
			$break_pasta = explode('/',$img);
			$file = array_pop($break_pasta);
			$folder = implode('/',$break_pasta);
			$break = explode('.',$file);
			$ext = strtolower(array_pop($break));
			$name = implode('.',$break);
			// READ DIR
			self::isNew($img);
			$duplic = '_D';
			$wn = $width ?	"_w$width"	: "";
			$hn = $height ?	"_h$height"	: "";
			$ext_crop = '';
			if($crop === true):
				$ext_crop = '_cr'; 
			elseif(strlen($crop) > 0):
				$ext_crop = '_cr_'.$crop; 
			endif;
			$img = "$name$duplic$wn$hn$ext_crop.$ext";
			$folder = strlen($folder) > 0 ? "$folder" : '.';
			if(!file_exists("$folder/$img") && ($width || $height)):
				$arquivo = md5(uniqid()).".$ext";
				copy($original, $arquivo);
				$verot = new VerotImagePlugin($arquivo,'pt_BR');
				$nomeNovo = "$name$duplic$wn$hn$ext_crop";
				$verot->allowed = array('image/*');
				$verot->file_new_name_body	= $nomeNovo;
				$verot->jpeg_quality = 50;
				$verot->image_resize = true;
				$verot->file_auto_rename = false;
				$verot->image_ratio_crop = strlen($ext_crop) > 0 ? $crop : true;
				$verot->image_default_color = '#000000';
				//var_dump($verot->error);die;
				if(strlen($ext_crop) > 0):
					if($width):
						//$verot->image_min_width	= $width;
						$verot->image_x	= $width;
					endif;
					if($height):
						//$verot->image_min_height = $height;
						$verot->image_y	= $height;
					endif;
				elseif($width && $height):
					$verot->image_x	= $width;
					$verot->image_y	= $height;
					$rh = ($width*$verot->image_dst_y/$verot->image_dst_x);
					if($rh > $height):
						$verot->image_ratio_x = true;
					else:
						$verot->image_ratio_y = true;
					endif;
				elseif($width):
					$verot->image_x	= $width;
					$rh = ($width*$verot->image_dst_y/$verot->image_dst_x);
					if($rh > $height):
						$verot->image_ratio_y = true;
					endif;
				elseif($height):
					$verot->image_y	= $height;
					$rh = ($width*$verot->image_dst_y/$verot->image_dst_x);
					if($rh < $height):
						$verot->image_ratio_x = true;
					endif;
				
				endif;
				
				$verot->process($folder);
				if ($verot->processed):
					$nomeArquivo = $verot->file_dst_name_body.'.'.strtolower($verot->file_dst_name_ext);
				else:
					$erro = utf8_decode($verot->error);
					$img = $original;
					$redirect = false;
				endif;
				$verot->clean();
			endif;
			if($redirect):
				$img = H::root()."$folder/$img";
				header("Location: $img");
			else:
				//header("Location: warning.jpg");
				echo $erro;
			endif;
			
		else:
			echo $img;
			//header("Location: image-not-found.gif");
		endif;
	}
	
	public static function isNew($filename)
	{
		$break = explode('.',$filename);
		$ext = array_pop($break);
		$prefix = implode('.',$break).'_D';
		$txt = $prefix.'.txt';
		$old_modifi = -1;
		if(file_exists($txt)):
			$handle = fopen ($txt, "r");
			$old_modifi = fread ($handle, filesize ($txt));
			fclose ($handle);
		endif;
		$new_modifi = filemtime($filename);
		//echo "$old_modifi != $new_modifi <br/>";
		if($old_modifi != $new_modifi):
			$mask = $prefix."*";
			array_map( "unlink", glob( $mask ));
				
			$fp = fopen($txt, "w+");
			fwrite($fp, $new_modifi);
			fclose($fp);
		endif;
	}
}