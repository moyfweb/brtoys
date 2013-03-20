<?php
class form
{
	private $fields = array();
	
	public function __construct() {	}
	
	public function openForm($nome,$action,$id='frm',$extra=null,$method=null,$enctype=null,$class=null) {
		if(empty($method)) $method='post';
		if(empty($enctype)) $enctype='multipart/form-data';
		if(empty($class)) $class='validar';
		return "<form name='$nome' action='$action' id='$id' method='$method' enctype='$enctype' class='$class' $extra>";
	}
	
	public function hidden($field, $label, $value, $array_config = array()) {
		if(is_array($field)):
			list($cfg,$field_id,$field_name,$field_options,$field_label,$options,$class) = $this->fieldConfigs($field,$array_config);
			$conteudo = "
				<input type='hidden' name='$field_name' class='$class' value='$value' id='$field_id'/>
				<input type='hidden' value='$options' name='$field_options' />
				<input type='hidden' value='$label' name='$field_label' />
				";
			return $conteudo;
		else:
			return 'Primeiro parametro precisa ser um array.';
		endif;
	}
	
	public function text($field, $label, $value, $array_config = array()) {
		if(is_array($field)):
			list($cfg,$field_id,$field_name,$field_options,$field_label,$options,$class) = $this->fieldConfigs($field,$array_config);
			$conteudo = "
			<p $cfg->p>
				<label for='$field_id' class='legend'>$label</label>
				<input name='$field_name' class='$class' type='text' value='$value' id='$field_id'  $cfg->style/>
				<input type='hidden' value='$options' name='$field_options' />
				<input type='hidden' value='$label' name='$field_label' />
				<span class='erro'>$cfg->erro</span>
			</p>";
			return $conteudo;
		else:
			return 'Primeiro parametro precisa ser um array.';
		endif;
	}
	
	public function password($field, $label, $value, $array_config = array()) {
		if(is_array($field)):
			list($cfg,$field_id,$field_name,$field_options,$field_label,$options,$class) = $this->fieldConfigs($field,$array_config);
			$conteudo = "
			<p $cfg->p>
				<label for='$field_id' class='legend'>$label</label>
				<input name='$field_name' class='$class' type='password' value='$value' id='$field_id'  $cfg->style/>
				<input type='hidden' value='$options' name='$field_options' />
				<input type='hidden' value='$label' name='$field_label' />
				<span class='erro'>$cfg->erro</span>
			</p>";
			return $conteudo;
		else:
			return 'Primeiro parametro precisa ser um array.';
		endif;
	}
	
	public function textarea($field, $label, $value, $array_config = array()) {	
		if(is_array($field)):
			list($cfg,$field_id,$field_name,$field_options,$field_label,$options,$class) = $this->fieldConfigs($field,$array_config);
			$conteudo = "
			<p $cfg->p>
				<label for='$field_id' class='legend'>$label</label>
				<textarea name='$field_name' class='$class' id='$field_id'  $cfg->style >$value</textarea>
				<input type='hidden' value='$options' name='$field_options' />
				<input type='hidden' value='$label' name='$field_label' />
				<span class='erro'>$cfg->erro</span>
			</p>";
			return $conteudo;
		else:
			return 'Primeiro parametro precisa ser um array.';
		endif;
	}
	
	public function select($field, $label, $value, $list_option, $array_config = array()) {	
		if(is_array($field)):
			list($cfg,$field_id,$field_name,$field_options,$field_label,$options,$class) = $this->fieldConfigs($field,$array_config);
			$select_options = '';
			foreach($list_option as $option):
				list($v,$t) = $option;
				$selected = $value == $v ? "selected='selected'" : '';
				$select_options .= "
					<option value='$v' $selected>$t</option>";
			endforeach;
				
			$conteudo = "
			<p $cfg->p>
				<label for='$field_id' class='legend'>$label</label>
				<select name='$field_name' class='$class' id='$field_id'  $cfg->style >
					$select_options
				</select>
				<input type='hidden' value='$options' name='$field_options' />
				<input type='hidden' value='$label' name='$field_label' />
				<span class='erro'>$cfg->erro</span>
			</p>";
			return $conteudo;
		else:
			return 'Primeiro parametro precisa ser um array.';
		endif;
	}
	
	public function checkbox($field, $label, $value, $array_config = array(),$ck=false) {	
		if(is_array($field)):
			list($cfg,$field_id,$field_name,$field_options,$field_label,$options,$class) = $this->fieldConfigs($field,$array_config);
			$ckd = $ck ? "checked='checked'" : '';
			$conteudo = "
			<p $cfg->p>
				<label for='$field_id' class='legend'>
				<input name='$field_name' class='$class' type='checkbox' value='$value' id='$field_id'  $cfg->style $ckd/>
				<span>$label</span> </label>
				<input type='hidden' value='$options' name='$field_options' />
				<input type='hidden' value='$label' name='$field_label' />
				<span class='erro'>$cfg->erro</span>
			</p>";
			return $conteudo;
		else:
			return 'Primeiro parametro precisa ser um array.';
		endif;
	}

	public function radio($field, $label, $value, $list_option, $array_config = array()) {	
	if(is_array($field)):
			list($cfg,$field_id,$field_name,$field_options,$field_label,$options,$class) = $this->fieldConfigs($field,$array_config);
			
			$radio_options = '';
			$required = $cfg->obrigatorio != false ? " validate='required:true' ":'';

			foreach($list_option as $k=>$option):
				list($v,$t) = $option;
				$checked = $value == $v ? "checked='checked'" : '';
				$id = $field_id.'_radio_'. $v;
				$radio_options .= "
					<label><input name='$field_name' type='radio' value='$v' id='$id' $checked />
					<span>$t</span>
					</label>
					";
			endforeach;
			
			$conteudo = "
			<div $cfg->p>
				<label class='legend'>$label</label>
				<div class='$class'>
				$radio_options
				</div>
				<input type='hidden' value='$options' name='$field_options' />
				<input type='hidden' value='$label' name='$field_label' />
				<span class='erro'>$cfg->erro</span>
			</div>";
			return $conteudo;
		else:
			return 'Primeiro parametro precisa ser um array.';
		endif;
	}
	
	private function fieldConfigs($field,$array_config){
		$cfg = $this->setConfigs($array_config);
		array_unshift($field,'field');
		$field_id = implode('_',$field);
		array_shift($field);
		$prefix = array_shift($field);
		$sufix = count($field) ? '['.implode('][',$field).']' : '';

		$field_name = $prefix.$sufix;
		$field_options = $prefix.'_options'.$sufix;
		$field_label = $prefix.'_label'.$sufix;
		$opt = new stdClass();
		$opt->type = $cfg->type;
		$options = json_encode($opt);
		$this->fields[] = $field_name;
		$key = end($field);
		$class = implode(' ',array($cfg->type, $cfg->class));
		$cfg->erro = isset($cfg->errors[$key]) ? $cfg->errors[$key] : null;
		return array($cfg,$field_id,$field_name,$field_options,$field_label,$options,$class);
	}
	
	private function setConfigs($configs)
	{
		$config = (object)$configs;
		$cfg = new stdClass();
		$cfg->obrigatorio = isset($config->obrigatorio) ? $config->obrigatorio : false;
		$cfg->errors = isset($config->errors) ? $config->errors : array();
		$cfg->value = isset($config->value) ? "$config->value" : '';
		$cfg->style = isset($config->style) ? "style='$config->style'" : '';
		$cfg->linhas = isset($config->linhas) ? $config->linhas : 1;
		$cfg->p = isset($config->p) ? $config->p : '';
		$cfg->type = isset($config->type) ? $config->type : null;
		$cfg->class = isset($config->class) ? $config->class : '';
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