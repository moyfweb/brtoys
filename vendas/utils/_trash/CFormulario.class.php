<?php
class CFormulario
{
	private $fields = array();
	
	public function __construct() {	}
	
	public function openForm($nome,$action,$id='frm',$extra=null,$method=null,$enctype=null,$class=null) {
		if(empty($method)) $method='post';
		if(empty($enctype)) $enctype='multipart/form-data';
		if(empty($class)) $class='validar';
		return "<form name='$nome' action='$action' id='$id' method='$method' enctype='$enctype' class='$class' $extra>";
	}
	
	public function textField($nome, $id, $label, $array_config = array()) {
		$this->fields[] = $nome;
		$cfg = $this->setConfigs($array_config);
		$conteudo = "
		<div $cfg->div_class>
			<label for='$id' class='legend'>$label</label>
			<input name='$nome' class='$cfg->required $cfg->class' type='text' value='$cfg->value' $cfg->style id='$id'/>
			<input type='hidden' value='$cfg->obrigatorio' name='".$id."_REQUIRED'>
			<input type='hidden' value='$label' name='".$id."_LABEL'>
			<div class='erro'>$cfg->erro</div>
		</div>";
		return $conteudo;
	}
	
	public function keyField($nome, $id, $label, $array_config = array()) {
		$this->fields[] = $nome;
		$cfg = $this->setConfigs($array_config);
		$conteudo = "
		<div $cfg->div_class>
			<label for='$id' class='legend'>$label</label>
			<input name='$nome' class='$cfg->required $cfg->class' type='password' value='$cfg->value' $cfg->style id='$id'/>
			<input type='hidden' value='$cfg->obrigatorio' name='".$id."_REQUIRED'>
			<input type='hidden' value='$label' name='".$id."_LABEL'>
			<div class='erro'>$cfg->erro</div>
		</div>";
		return $conteudo;
	}
	
	public function textArea($nome, $id, $label, $array_config = array())
	{
		$this->fields[] = $nome;
		$cfg = $this->setConfigs($array_config);
		$conteudo = "
		<div $cfg->div_class>
			<label for='$id' class='legend'>$label</label>
			<textarea name='$nome' rows='$cfg->linhas' class='$cfg->required $cfg->class' $cfg->style  id='$id'>$cfg->value</textarea>
			<input type='hidden' value='$cfg->obrigatorio' name='".$id."_REQUIRED'>
			<input type='hidden' value='$label' name='".$id."_LABEL'>
			<div class='erro'>$cfg->erro</div>
		</div>";
		return $conteudo;
	}
	
	public function select($nome, $id, $label, $list_option,$array_config = array())
	{
	
		$this->fields[] = $nome;
		$cfg = $this->setConfigs($array_config);
		$options = '';
		$value = isset($cfg->value) ? $cfg->value : null;
		foreach($list_option as $option):
			$v = (object)$option;
			$selected = $value == $v->valor ? "selected='selected'" : '';
			$options .= "
				<option value='$v->valor' $selected>$v->texto</option>";
		endforeach;
		$conteudo = "
		<div $cfg->div_class>
			<label for='$id' class='legend'>$label</label>
			<select name='$nome' class='$cfg->required $cfg->class' $cfg->style id='$id'>
			$options
			</select>
			<input type='hidden' value='$cfg->obrigatorio' name='".$id."_REQUIRED'>
			<input type='hidden' value='$label' name='".$id."_LABEL'>
			<div class='erro'>$cfg->erro</div>
		</div>";
		return $conteudo;

	}
	
	public function checkbox($nome, $id, $label, $array_config = array()) {
		$this->fields[] = $nome;
		$cfg = $this->setConfigs($array_config);
		$chkd='';
		if(isset($cfg->value)) { $chkd = $cfg->value == 1 ? "checked='checked'" : ''; }
		
		$conteudo = "
		<div $cfg->div_class>
			<input name='$nome' class='$cfg->required $cfg->class' type='checkbox' $cfg->style id='$id' value='1' $chkd />
			<label for='$id'>$label</label>
			<input type='hidden' value='$cfg->obrigatorio' name='".$id."_REQUIRED'>
			<input type='hidden' value='$label' name='".$id."_LABEL'>
			<div class='erro'>$cfg->erro</div>
		</div>";
		return $conteudo;
	}

	public function radioGroup($nome, $id, $label, $list_option,$array_config = array())
	{
	
		$this->fields[] = $nome;
		$cfg = $this->setConfigs($array_config);
		$options = '';
		$required = $cfg->obrigatorio != false ? " validate='required:true' ":'';
		$count=0;
		foreach($list_option as $option):
			$v = (object)$option;
			$id = 'radio_'.count($this->fields).'_'.$count;
			$options .= "
				<input name='$nome' id='$id' class='$cfg->class $cfg->required' type='radio' value='$v->valor' $cfg->style $required/>
				<label for='$id' class='radio'>$v->texto</label>
				";
			$count++;
		endforeach;
		$conteudo = "
		<div $cfg->div_class>
			<label  class='radio_legend'>$label</label>
			<div>
			$options
			</div>
			<input type='hidden' value='$cfg->obrigatorio' name='".$id."_REQUIRED'>
			<input type='hidden' value='$label' name='".$id."_LABEL'>
			<div class='erro'>$cfg->erro</div>
		</div>";
		return $conteudo;

	}
	
	private function setConfigs($configs)
	{
		$config = (object)$configs;
		$cfg = new stdClass();
		$cfg->obrigatorio = isset($config->obrigatorio) ? $config->obrigatorio : false;
		$cfg->erro = isset($config->erro) ? $config->erro : '';
		$cfg->value = isset($config->value) ? "$config->value" : '';
		$cfg->style = isset($config->style) ? "style='$config->style'" : '';
		$cfg->linhas = isset($config->linhas) ? $config->linhas : 1;
		$cfg->div_class = isset($config->div_class) ? "class='$config->div_class'" : '';
		$cfg->class = isset($config->class) ? $config->class : '';
		$cfg->required = $cfg->obrigatorio ? 'required':'';
		return $cfg;
	}
	
	public function closeForm()
	{
		$campos = json_encode($this->fields);
		$conteudo = "
			<input type='hidden' value='$campos' name='json_campos'/>
		</form>
		";
		return $conteudo;
	}
	
	
	public function getPosts()
	{
		$data = new stdClass();
		if(isset($_POST['json_campos'])):
			$campos = json_decode($_POST['json_campos']);
			foreach($campos as $v):
				$data->{$v} = (object) array ('valor'=>$_POST[$v],'label'=>$_POST[$v.'_LABEL']);
			endforeach;
		endif;
		return $data;
	}	
}