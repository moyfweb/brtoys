<?php
class arquivo_controller
{

	public static function download()
	{
		// The file
		$uri = $_SERVER['REQUEST_URI'];
		$ext = end(explode('.',$uri));
		$uris = explode('/',$uri);
		$file_newname = array_pop($uris);
		$file_name = 'files/files/'.array_pop($uris).'.'.$ext;

		//echo $file_name;die;
		header("Content-Type: application/save");
		header("Content-Length:".filesize($file_name)); 
		header('Content-Disposition: attachment; filename="' . $file_newname . '"'); 
		header("Content-Transfer-Encoding: binary");
		header('Expires: 0'); 
		header('Pragma: no-cache'); 

		// nesse momento ele le o arquivo e envia
		$fp = fopen("$file_name", "r"); 
		fpassthru($fp); 
		fclose($fp); 
	}
	
	public static function img()
	{
		// The file
		$uri = $_SERVER['REQUEST_URI'];
		$ext = end(explode('.',$uri));
		$uris = explode('/',$uri);
		array_pop($uris);
		$filename = 'files/files/'.array_pop($uris).'.'.$ext;

		// Get new dimensions
		list($w,$h) = getimagesize($filename);

		// Resample
		$image_p = imagecreatetruecolor($w,$h);
		header('Accept-Ranges: bytes');
		
		switch(strtolower($ext))
		{
			case 'jpg':
			case 'jpeg':
				header('Content-Type: image/jpeg');
				$image = imagecreatefromjpeg($filename);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w, $h, $w, $h);
				imagejpeg($image_p, null, 100);
				break;
			case 'png':
				header('Content-Type: image/png');
				$image = self::LoadPNG($filename);
				imagepng($image);
				break;
			case 'gif':
				header('Content-Type: image/gif');
				$image = imagecreatefromgif($filename); 
				$background = imagecolorallocate($image, 0, 0, 0);
				imagecolortransparent($image, $background);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $w, $h, $w, $h);
				imagegif($image_p, null, 100);
				break;
			default:
				echo 'erro';
		}
	}
	
	public static function resize()
	{		
		$img = isset($_GET['img']) ? 'arquivos/upload/'.$_GET['img'] : null;
		$width = isset($_GET['w']) ? $_GET['w'] : null;
		$height = isset($_GET['h']) ? $_GET['h'] : null;
		$crop = isset($_GET['crop']) ? $_GET['crop'] : false;
		ImagePlugin::resize($img,$width,$height,$crop);
	}
	
	private static function LoadPNG($imgname) 
	{
		$im = @imagecreatefrompng($imgname); /* Attempt to open */
		if($im):
			$background = imagecolorallocate($im, 0, 0, 0);
			imagecolortransparent($im, $background);
			imagealphablending($im, false);
			imagesavealpha($im, true);
		else: /* See if it failed */
			$im  = imagecreatetruecolor(150, 30); /* Create a blank image */
			$bgc = imagecolorallocate($im, 255, 255, 255);
			$tc  = imagecolorallocate($im, 0, 0, 0);
			imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
			/* Output an errmsg */
			imagestring($im, 1, 5, 5, "Error loading $imgname", $tc);
		endif;
		return $im;
	}
}