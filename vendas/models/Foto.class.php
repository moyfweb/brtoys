<?php
class Foto extends CModel {

	public $IDFoto = null;
	public $Arquivo = null;
	public $Tamanho = null;
	public $Nome = null;
	public $Descricao = null;
	public $Status = null;
	
	public function __construct()
	{
		parent::__construct();
		H::connect();
		$this->setClass(get_class());
		$this->setPK('IDFoto');
		$this->setTable('ecom_foto');
		$this->addWhere('Status > -1');
	}
	
	public function getLabel($key) {
		$labels = array();
		$labels['IDFoto'] = 'PK';
		$labels['Arquivo'] = 'Arquivo';
		$labels['Tamanho'] = 'Tamanho';
		$labels['Nome'] = 'Nome';
		$labels['Descricao'] = 'Descrição';
		$labels['Status'] = 'Status';
		return $labels[$key];
	}
	
	public function getType($key) {
		$types = array();
		$types['Arquivo'] = 'string';
		$types['Nome'] = 'string';
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
	public static function requestSave($request) {
		$model = new self();
		$file = Foto::upload();
		$model->request($request);
		if($file):
			$model->Tamanho = $file->Tamanho;
			$model->Arquivo = $file->Arquivo;
		elseif(!empty($model->IDFoto)):
			$data = $model->findOne();
			$model->Tamanho = $data->Tamanho;
			$model->Arquivo = $data->Arquivo;
		else:
			die('Nenhuma foto foi enviada!');
		endif;
		
		if(empty($model->IDFoto)) $model->IDFoto = null;
		
		if(!empty($model->Nome)):
			$new = $model->IDFoto == null ? true : false;
			if(!$data = $model->save()) die('Não foi possivel executar Foto::save()');
			else return (!$new ? false : $data->IDFoto);
		endif;
	}
	
	public static function upload() {
		$upload = isset($_FILES['file']) ? $_FILES['file'] : null;
		if ($upload || isset($_SERVER['HTTP_X_FILE_NAME'])):
			$info = new stdClass();
			$info->temp = self::fileInfo($upload,'NULL','tmp_name');
			$info->FileName = self::fileInfo($upload,'HTTP_X_FILE_NAME','name');
			$info->Tamanho = self::fileInfo($upload,'HTTP_X_FILE_SIZE','size');
			$info->Tamanho = ((int)$info->Tamanho)/1000;
			$info->Tipo = self::fileInfo($upload,'HTTP_X_FILE_TYPE','type');
			$info->Error = self::fileInfo($upload,'NULL','error');
			$info->Ext = strtolower(end(explode('.',$info->FileName)));
			$info->Ext = str_replace('jpeg','jpg',$info->Ext);
			$name = uniqid();
			$folder = 'arquivos/upload/foto/';
			$thumb_folder = 'arquivos/upload/thumb/';
			$info->Arquivo = $name.'.'.$info->Ext;
			if(empty($info->FileName)): return false;
			elseif(!in_array($info->Ext,array('jpg','gif','png','bmp'))): die('Não é uma imagem');
			else:
				self::limitSize($info->temp,$folder,$name,$info->Ext,1200,900);
				self::limitSize($folder.$info->Arquivo,$thumb_folder,$name,$info->Ext,400,300);
				
			endif;	
			return $info;
		else:
			return false;
        endif;
		
	}

	private static function fileInfo($upload,$server,$propriety) {
		if(isset($_SERVER[$server])): return $_SERVER[$server];
		elseif(isset($upload[$propriety])): return $upload[$propriety];
		else: return null;
		endif;
	}

	private static function limitSize($temp,$folder,$name,$ext,$width,$height) {
				
		$verot = new VerotImagePlugin($temp,'pt_BR');
		$verot->allowed = array('image/*');
		$verot->file_new_name_body = $name;
		$verot->file_new_name_ext = $ext;
		$verot->jpeg_quality = 50;
		$verot->image_resize = true;
		$verot->file_auto_rename = false;
		$verot->image_ratio_crop = false;
		$verot->image_default_color = '#000000';
		//var_dump($verot->error);die;
		if($width && $height):
			$verot->image_x	= $width;
			$verot->image_y	= $height;
			$verot->image_ratio_no_zoom_in = true;
		elseif($width):
			$verot->image_x	= $width;
			$verot->image_y	= 10 * $width;
			$verot->image_ratio_no_zoom_in = true;
		elseif($height):
			$verot->image_y	= $height;	
			$verot->image_x	= 10 * $height;	
			$verot->image_ratio_no_zoom_in = true;			
		endif;
		$verot->process($folder);
	}

}