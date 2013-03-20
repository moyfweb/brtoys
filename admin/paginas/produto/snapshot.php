<?php

/*
	This file receives the JPEG snapshot
	from webcam.swf as a POST request.
*/

// We only need to handle POST requests:
if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
	exit;
}

$folder = 'arquivos/upload/';
$filename = uniqid().'.jpg';

$original = $folder.$filename;

// The JPEG snapshot is sent as raw input:
$input = file_get_contents('php://input');

if(md5($input) == '7d4df9cc423720b7f1f3d672b89362be'){
	// Blank image. We don't need this one.
	exit;
}

$result = file_put_contents($original, $input);
if (!$result) {
	echo '{
		"error"		: 1,
		"message"	: "Failed save the image. Make sure you chmod the uploads folder and its subfolders to 777."
	}';
	exit;
}

$info = getimagesize($original);
if($info['mime'] != 'image/jpeg'){
	unlink($original);
	exit;
}

// Moving the temporary file to the originals folder:
rename($original,'arquivos/upload/foto/'.$filename);
$original = 'arquivos/upload/foto/'.$filename;

// Using the GD library to resize 
// the image into a thumbnail:

#$origImage	= imagecreatefromjpeg($original);
#$newImage	= imagecreatetruecolor(154,110);
#imagecopyresampled($newImage,$origImage,0,0,0,0,154,110,520,370); 

#imagejpeg($newImage,'arquivos/upload/thumb/'.$filename);

Foto::limitSize($original,'arquivos/upload/thumb/',current(explode('.',$filename)),end(explode('.',$filename)),400,300);



$model = new Produto();
$model->IDProduto = H::cod();
$produto = $model->findOne();

$model = new ProdutoFotoR();
$model->IDProduto = H::cod();
#$model->setPagination();
$fotos = $model->findAll();
$titulo = sprintf('%s_%s',$produto->Nome,str_pad(count($fotos),3,0, STR_PAD_LEFT));

$model = new Foto();
$model->Tamanho = filesize($original)/1000;
$model->Arquivo = $filename;
$model->Nome = $titulo;
if(!$data = $model->save()): die('Não foi possivel executar Foto::save()');
else: 
	$model_p = new ProdutoFoto();
	$model_p->IDFoto = $data->IDFoto;
	$model_p->IDProduto = H::cod();
	if(!$data_p = $model_p->save()) die('Não foi possivel executar ProdutoFoto::save()');
endif;
	
	
echo '{"status":1,"message":"Success!","filename":"'.$filename.'"}';



