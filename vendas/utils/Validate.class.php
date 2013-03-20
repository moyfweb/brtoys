<?php

/*   This script remains free until these lines are changed or removed
  // +--------------------------------------------------------------------------------+
  // | class.Validation.php : Allows you to validate any type of data sent by users   |
  // |--------------------------------------------------------------------------------|
  // |   This program is free software; you can redistribute it and/or                |
  // | modify it under the terms of the GNU General Public License          	      |
  // | as published by the Free Software Foundation of the License 		      |
  // |                                                                                |
  // |   This program is distributed in the hope that it will be useful,              |
  // | but WITHOUT ANY WARRANTY; without even the implied warranty of                 |
  // | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                  |
  // | GNU General Public License for more details.                                   |
  // |--------------------------------------------------------------------------------|
  // | Name of the script		:	class.Validate.php                    |
  // | Author			:	Magd Kudama <magdkudama@gmail.com>            |
  // | Version			:	v1.0                                          |
  // | URL			:	magdkudama.com/blog                           |
  // +--------------------------------------------------------------------------------+
 */

class Validate
{

    var $error_level;
    var $enviornment;
    var $message;
    var $field;
    var $add_called = false;
    var $elements = array();
    var $errors_in_validation = '';
    var $errors = array();
    var $count;
    var $dec = '<strong>ERROR:</strong> ';

    function is_assoc($array) {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    private function showErrors($error) {
        die($error);
    }

    private function showValidation($text='') {
        return empty($text) ? '' : ($this->error_level == 'specific' ? $text . '' : '');
    }

    private function setErrorLevel($error_level) {
        if (in_array($error_level, array('specific', 'general')))
            $this->error_level = $error_level;
        else
            $this->showErrors($this->dec . _('Incorrecto ERROR_LEVEL!'));
    }

    private function setEnviornment($enviornment) {
        if (in_array($enviornment, array('development', 'production')))
            $this->enviornment = $enviornment;
        else
            $this->showErrors($this->dec . _('Incorrecto ENVIORNMENT!'));
    }

    public function __construct($error_level, $enviornment='development',$lang) {
		$this->errors = array();
		putenv('LC_ALL='.$lang);
		setlocale(LC_ALL, $lang);
		bindtextdomain('messages', './locale');
		textdomain('messages');
		
        $this->setErrorLevel($error_level);
        $this->setEnviornment($enviornment);
    }

    public function numberOfElements() {
        if ($this->add_called)
            return $this->count;
        else
            $this->showErrors($this->dec . _('NUMBEROFELEMENTS não pode ser chamado antes de ADDARRAY!'));
    }

    private function validatePropertie($value, $type) {
        switch ($type) {
            case 'int':
                if (!ctype_digit($value))
                    return false;
                break;
            case 'flo':
                if (!is_numeric($value))
                    return false;
                break;
            case 'date':
                if (strlen($value) != 10 || substr($value, 2, 1) != substr($value, 5, 1) || ctype_alnum(substr($value, 2, 1)))
                    return false;
                break;
            case 'bit':
                if (!in_array($value, array('0', '1')))
                    return false;
                break;
            case 'str1':
                if (strlen($value) != 1 || ctype_alnum($value))
                    return false;
                break;
            case 'arr':
                if (!is_array($value))
                    return false;
                break;
            case 'str':
                if (!is_string($value))
                    return false;
                break;
            case '':
                return true;
                break;
            default:
                return false;
        }
        return true;
    }

	private function validateFormat($date,$sql) {
		if ($sql==0) {
			$sep1=substr($date, 2, 1);
			$sep2=substr($date, 5, 1);
			$day=substr($date, 0, 2);
			$month=substr($date, 3, 2);
			$year=substr($date, 6);
		}
		else {
			$sep1=substr($date, 4, 1);
			$sep2=substr($date, 7, 1);
			$day=substr($date, 8);
			$month=substr($date, 5, 2);
			$year=substr($date, 0, 4);
		}
		if ($sep1!=$sep2 || !ctype_alnum($day) || !ctype_alnum($month) || !ctype_alnum($year))
			return false;
		return true;
	}
	
    private function checkProperties($array) {
        $properties =
                array(
                    'integer' => array('min' => 'int', 'max' => 'int'),
                    #'float' => array('min' => 'flo', 'max' => 'flo', 'numdec' => 'int'),
                    'date' => array('mindate' => 'date', 'maxdate' => 'date', 'sql' => 'bit', 'sep' => 'str1'),
                    'file' => array('minsize' => 'int', 'maxsize' => 'int', 'accformats' => 'arr'),
                    'string' => array('minchr' => 'int', 'maxchr' => 'int', 'accnum' => 'bit', 'accsp' => 'bit', 'like' => 'str'),
                    'hour' => array('sep' => 'str1', 'tfh' => 'bit'),
                    'ip' => array('onlyipv4' => 'bit'),
                    'rest' => array('valid' => 'arr'),
                    'dni' => array(),
                    'email' => array(),
                    'fone' => array(),
                    'url' => array(),
                    'pass' => array()
        );
        $required_properties = array('value', 'name', 'force', 'type');
        $analyze = array();

        $properties_na = array_keys($properties);

        for ($i = 0; $i < count($properties); $i++)
            array_push($analyze, $properties_na[$i]);

        for ($i = 0; $i < count($array); $i++) {
            if (!is_array($array[$i]) || !$this->is_assoc($array[$i]))
                $this->showErrors($this->dec . _('ADDARRAY deve receber um array associativo!'));

            for ($j = 0; $j < count($required_properties); $j++)
                if (!array_key_exists($required_properties[$j], $array[$i]))
                    $this->showErrors($this->dec . _('[VALUE,NAME,FORCE,TYPE] son requeridos!'));

            if (!in_array($array[$i]['type'], $analyze))
                $this->showErrors($this->dec . strtoupper($array[$i]['type']) . _(' não existe!'));

            $type = $properties[$array[$i]['type']];
            $type_keys = array_keys($properties[$array[$i]['type']]);

            if (empty($type_keys))
                continue;

            foreach ($array[$i] as $key => $propertie) {
				if ($key=='force' && !in_array($propertie,array('0','1')))
					$this->showErrors($this->dec . strtoupper($key) . _(' contem um valor incorreto!'));
				
                if (($key=='mindate' || $key=='maxdate')) {
					$sql=isset($array[$i]['sql']) ? $array[$i]['sql'] : '0';
					if (!$this->validateFormat($propertie,$sql))
						$this->showErrors($this->dec . strtoupper($key) . _(' deve conter um formato adequado!'));
				}
				
				if (!in_array($key, $type_keys) && !in_array($key, $required_properties))
                    $this->showErrors($this->dec . strtoupper($key) . _(' não existe!'));

                if (in_array($key, $type_keys)) {
                    $result = $this->validatePropertie($propertie, $properties[$array[$i]['type']][$key]);
                    if (!$result)
                        $this->showErrors($this->dec . strtoupper($key) . _(' contem um valor incorreto!'));
                }
            }
        }
    }

    public function addArray($array) {
        if (!$this->add_called) {
            $this->count = count($array);
            if ($this->enviornment == 'development')
                $this->checkProperties($array);
            $this->elements = $array;
            $this->add_called = true;
        }
        else
            $this->showErrors($this->dec . _('ADDARRAY ja foi chamado.'));
    }

    private function validateINTEGER($value) {
        $m = $this->message;

        if (!ctype_digit(strval($value)))
            return $this->showValidation($m . _('deve ser numérico.'));

        $options = array('options' => array());

        $haymin = (isset($this->elements[$this->row]['min'])) ? true : false;
        $haymax = (isset($this->elements[$this->row]['max'])) ? true : false;

        if ($haymin)
            $options['options']['min_range'] = $this->elements[$this->row]['min'];
        if ($haymax)
            $options['options']['max_range'] = $this->elements[$this->row]['max'];

        if (!filter_var($value, FILTER_VALIDATE_INT, $options)) {
            if ($haymin)
                $min = $this->elements[$this->row]['min'];
            if ($haymax)
                $max = $this->elements[$this->row]['max'];

            if ($haymin && $haymax)
                $m.=_('deve estar entre [') . $min . ' - ' . $max . '].';
            elseif ($haymin)
                $m.=_('deve ser maior que ') . $min . ' .';
            elseif ($haymax)
                $m.=_('deve ser menor que ') . $max . ' .';
            return $this->showValidation($m);
        }
        return $this->showValidation();
    }

    private function validateFLOAT($value) {
        $m = $this->message;
		
        if (!is_numeric($value))
            return $this->showValidation($m . _('deve ser numérico.'));
		
		
        $haymin = (isset($this->elements[$this->row]['min'])) ? true : false;
        $haymax = (isset($this->elements[$this->row]['max'])) ? true : false;

        

        if (!filter_var($value, FILTER_VALIDATE_FLOAT))
            return $this->showValidation($m . _('é inválido.'));


        if (strpos($value, '.') !== false) {
            $qdecimals = explode('.', $value);
            $qdecimals = strlen($qdecimals[1]);


            if ($haymin)
                $min = $this->elements[$this->row]['min'];
            if ($haymax)
                $max = $this->elements[$this->row]['max'];

            if ($haymin && $haymax && ($value > $max || $value < $min))
                return $this->showValidation($m . _('deve estar entre [') . $min . ' - ' . $max . '].');
            elseif ($haymin && !$haymax && ($value < $min))
                return $this->showValidation($m . _('deve ser maior que ') . $min . ' .');
            elseif (!$haymin && $haymax && ($value > $max))
                return $this->showValidation($m . _('deve ser menor que ') . $max . ' .');
        }
        else
            return $this->showValidation($m . _('deve conter ') . $dec . _(' números decimais.'));
        return $this->showValidation();
    }

    private function extractDate($date, $separation='/', $sql='0') {
        $date = explode($separation, $date);
        $month = $date[1];
        if ($sql == 0) {
            $year = $date[2];
            $day = $date[0];
        } else {
            $year = $date[0];
            $day = $date[2];
        }

        if ($day < 10)
            $day = '0' . $day;
        if ($month < 10)
            $day = '0' . $month;

        return $year . $month . $day;
    }

    private function validateDATE($value) {
        $m = $this->message;

        $sep = (isset($this->elements[$this->row]['sep'])) ? $this->elements[$this->row]['sep'] : '/';
        $sql = (isset($this->elements[$this->row]['sql'])) ? $this->elements[$this->row]['sql'] : '0';
        $haymin = (isset($this->elements[$this->row]['mindate'])) ? true : false;
        $haymax = (isset($this->elements[$this->row]['maxdate'])) ? true : false;

        $date = explode($sep, $value);

        if (count($date) != 3 || strlen($value) != 10) {
            $format = ($sql == 0) ? 'dd' . $sep . 'mm' . $sep . 'yyyy' : 'yyyy' . $sep . 'mm' . $sep . 'dd';
            return $this->showValidation($m . _(' deve ser preenchido no formato correto (') . $format . ')');
        }

        $month = $date[1];
        if ($sql == 0) {
            $year = $date[2];
            $day = $date[0];
        } else {
            $year = $date[0];
            $day = $date[2];
        }

        if (!checkdate((int) $month, (int) $day, (int) $year))
            return $this->showValidation($m . _(' data inválida.'));

        if ($haymin)
            $min = $this->elements[$this->row]['mindate'];
        if ($haymax)
            $max = $this->elements[$this->row]['maxdate'];

        if ($haymin && $haymax) {
            $mindate = $this->extractDate($min, $sep, $sql);
            $maxdate = $this->extractDate($max, $sep, $sql);
            $date = $this->extractDate($value, $sep, $sql);
            if ($date > $maxdate || $date < $mindate)
                return $this->showValidation($m . _('deve estar entre [') . $min . ' - ' . $max . '].');
        }
        elseif ($haymin && !$haymax) {
            $mindate = $this->extractDate($min, $sep, $sql);
            $date = $this->extractDate($value, $sep, $sql);
            if ($date < $mindate) return $this->showValidation($m . _('deve ser maior que ') . $min . ' .');
        } elseif (!$haymin && $haymax) {
            $maxdate = $this->extractDate($max, $sep, $sql);
            $date = $this->extractDate($value, $sep, $sql);
            if ($date > $maxdate) return $this->showValidation($m . _('deve ser menor que ') . $max . ' .');
        }
        return $this->showValidation();
    }

    private function DNI_Word($dni) {
        return substr('TRWAGMYFPDXBNJZSQVHLCKE', strtr($dni, 'XYZ', '012') % 23, 1);
    }

    private function validateDNI($value) {
        $m = $this->message;

        if (strlen($value) != 9) return $this->showValidation($m . _('deve conter 9 caracteres.'));

        $last = strtoupper(substr($value, -1));
        $first = strtoupper(substr($value, 0, 1));
        $numbers = str_replace('X', '0', strtoupper(substr($value, 0, -1)));

        if (!ctype_digit($first) && $first != 'X') return $this->showValidation($m . _('está errado (verifique o primeiro caractere).'));
        if (!ctype_digit($numbers)) return $this->showValidation($m . _(' incorreto'));
        if ($this->DNI_Word($numbers) != $last) return $this->showValidation($m . _(' contem uma letra incorreta.'));
		else return $this->showValidation();
    }

    private function validateEMAIL($value) {
        $m = $this->message . _('possui conteúdo inválido.');

        if (!filter_var($value, FILTER_VALIDATE_EMAIL))
            return $this->showValidation($m);
        return $this->showValidation();
    }
	
    private function validateFONE($value) {
        $m = $this->message . _(' não é válido, use o formato "(XX) XXXX-XXXX".');

        if (!preg_match("|\([0-9]{2}\) [0-9]{4}\-[0-9]{4}|",$value)) return $this->showValidation($m);
		else  return $this->showValidation();
    }
	
    private function validateCPF($value) {
        $m = $this->message . _(' não é válido, use o formato "XXX.XXX.XXX-XX".');

        if (!preg_match("|[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}|",$value)) return $this->showValidation($m);
		else  return $this->showValidation();
    }
	
    private function validateCEP($value) {
        $m = $this->message . _(' não é válido, use o formato "XX.XXX-XX".');

        if (!preg_match("|[0-9]{2}\.[0-9]{3}\-[0-9]{3}|",$value)) return $this->showValidation($m);
		else  return $this->showValidation();
    }
	
    private function validateURL($value) {
        $m = $this->message;

        if (!filter_var($value, FILTER_VALIDATE_URL))
            return $this->showValidation($m . _('possui conteúdo inválido.'));
        return $this->showValidation();
    }

    private function validateIP($value) {
        $m = $this->message;

        $option = '';

        if ($this->elements[$this->row]['onlyipv4'] == 1)
            $option = 'FILTER_FLAG_IPV4';
        if (!filter_var($value, FILTER_VALIDATE_IP, $option))
            if (!empty($option))
                return $this->showValidation($m . _('deve respeitar o protocolo IPv4.'));
            else
                return $this->showValidation($m . _('não é válido.'));

        return $this->showValidation();
    }

    private function validatePASS($value) {
        $m = $this->message . _('deve conter ');

        $haymin = (isset($this->elements[$this->row]['minchr'])) ? true : false;
        $haymax = (isset($this->elements[$this->row]['maxchr'])) ? true : false;

        if ($haymin)
            $minchr = $this->elements[$this->row]['minchr'];
        if ($haymax)
            $maxchr = $this->elements[$this->row]['maxchr'];

        if ($haymin && $haymax && (strlen($value) < $minchr || strlen($value) > $maxchr))
            return $this->showValidation($m . '[' . $minchr . ' - ' . $maxchr . _('] caracteres.'));
        elseif ($haymin && !$haymax && strlen($value) < $minchr)
            return $this->showValidation($m . 'no mínimo ' . $minchr . _(' caracteres.'));
        elseif (!$haymin && $haymax && strlen($value) > $maxchr)
            return $this->showValidation($m . 'no máximo ' . $maxchr . _(' caracteres.'));

        if (!preg_match('`[a-z]`', $value))
            return $this->showValidation($m . _('pelo menos 1 letra minuscula.'));
        if (!preg_match('`[A-Z]`', $value))
            return $this->showValidation($m . _('pelo menos 1 letra maiuscula.'));
        if (!preg_match('`[0-9]`', $value))
            return $this->showValidation($m . _('pelo menos 1 número.'));
        if (!ctype_alnum(str_replace(array('-', '_', '.'), '', $value)))
            return $this->showValidation($m . _('aceita apenas ( letras, números e [\'.\',\'_\',\'-\'] ).'));

        return $this->showValidation();
    }

    private function validateHOUR($value) {
        $m = $this->message;

        $sep = (isset($this->elements[$this->row]['sep'])) ? $this->elements[$this->row]['sep'] : ':';
        $hour = explode($sep, $value);

        if (strlen($value) != 5)
            return $this->showValidation($m . _('não é válido.'));

        if (count($hour) != 2) {
            $format = 'HH' . $sep . 'MM';
            return $this->showValidation($m . _('não é válido (') . $format . ').');
        }

        $minute = $hour[1];
        $hour = $hour[0];

        $haytfh = (isset($this->elements[$this->row]['tfh'])) ? true : false;

        if (!ctype_digit($minute) || !ctype_digit($hour))
            return $this->showValidation($m . _('horário inválido.'));

        if ($haytfh && $this->elements[$this->row]['tfh'] == '1') {
            if ($hour < 0 || $hour >= 24 || $minute < 0 || $minute > 59)
                return $this->showValidation($m . _('horário inválido (deve ser no formato 24h).'));
        }
        else {
            if ($hour < 0 || $hour >= 12 || $minute < 0 || $minute > 59)
                return $this->showValidation($m . _('horário inválido (deve ser no formato 12h).'));
        }
        return $this->showValidation();
    }

    private function validateSTRING($value) {
        $m = $this->message;
        $haymin = (isset($this->elements[$this->row]['minchr'])) ? true : false;
        $haymax = (isset($this->elements[$this->row]['maxchr'])) ? true : false;
        $hayaccnum = (isset($this->elements[$this->row]['accnum'])) ? true : false;
        $hayaccsp = (isset($this->elements[$this->row]['accsp'])) ? true : false;
        $haylike = (isset($this->elements[$this->row]['like'])) ? true : false;

        if ($haymin)
            $minchr = $this->elements[$this->row]['minchr'];
        if ($haymax)
            $maxchr = $this->elements[$this->row]['maxchr'];
        if ($hayaccnum)
            $accnum = $this->elements[$this->row]['accnum'];
        if ($hayaccsp)
            $accsp = $this->elements[$this->row]['accsp'];
        if ($haylike)
            $like = $this->elements[$this->row]['like'];

        if ($haymin && $haymax && (strlen($value) < $minchr || strlen($value) > $maxchr))
            return $this->showValidation($m . _('deve ter entre [') . $minchr . ' - ' . $maxchr . '] caracteres');
        elseif ($haymin && !$haymax && strlen($value) < $minchr)
            return $this->showValidation($m . _('deve ter mais que ') . $minchr . ' caracteres');
        elseif (!$haymin && $haymax && strlen($value) > $maxchr)
            return $this->showValidation($m . _('deve ter menos que ') . $maxchr . ' caracteres');

        if ($hayaccnum && $accnum == '0' && preg_match('`[0-9]`', $value))
            return $this->showValidation($m . _('não pode conter números.'));
        if ($hayaccsp && $accsp == '0' && strpos($value, ' ') !== false)
            return $this->showValidation($m . _('não deve conter espaços.'));
        if ($haylike) {
            $last = (substr($like, 0, 1) == '%') ? true : false;
            $first = (substr($like, -1) == '%') ? true : false;

            $str = str_replace('%', '', $like);

            if ($first && $last) {
                if (strpos(strtolower($value), strtolower($str)) === false)
                    return $this->showValidation($m . _('deve conter a sequência \'') . $str . '\'');
            } elseif ($first) {
                if (strtolower(substr($value, 0, strlen($str))) != strtolower($str))
                    return $this->showValidation($m . _('deve começar por \'') . $str . '\'');
            } elseif ($last) {
                if (strtolower(substr($value, -strlen($str))) != strtolower($str))
                    return $this->showValidation($m . _('deve terminar em \'') . $str . '\'');
            }
        }
        return $this->showValidation();
    }

    private function formatSize($size) {
        $sizes = array(' Bytes', ' KB', ' MB', ' GB', ' TB', ' PB', ' EB', ' ZB', ' YB');
        return (round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]);
    }

    private function validateFILE($value) {
        $m = $this->message;

        $size = $this->elements[$this->row]['value']['size'];
        $type = $this->elements[$this->row]['value']['type'];

        $haymin = (isset($this->elements[$this->row]['minsize'])) ? true : false;
        $haymax = (isset($this->elements[$this->row]['maxsize'])) ? true : false;

        if ($haymin) $minsize = $this->elements[$this->row]['minsize'];
        if ($haymax) $maxsize = $this->elements[$this->row]['maxsize'];

        if ($haymin && $haymax && ($size > $maxsize || $size < $minsize))
            return $this->showValidation($m . _('deve estar entre [') . $this->formatSize($minsize) . ' - ' . $this->formatSize($maxsize) . '].');
        elseif ($haymin && !$haymax && $size < $minsize)
            return $this->showValidation($m . _('deve ser maior que ') . $this->formatSize($minsize) . '.');
        elseif (!$haymin && $haymax && $size > $maxsize)
            return $this->showValidation($m . _('deve ser menor que ') . $this->formatSize($maxsize) . '.');

        if (isset($this->elements[$this->row]['accformats'])) {
            $accformats = $this->elements[$this->row]['accformats'];
            if (array_search($type, $accformats) === false) {
                $string = '[ ';
                for ($i = 0; $i < count($accformats); $i++) {
                    $elements = explode('/', $accformats[$i]);
                    $string.=$elements[1] . ' , ';
                }
                $string = substr($string, 0, -2) . ']';
                return $this->showValidation($m . _('deve conter o formato ') . $string . '.');
            }
        }
        return $this->showValidation();
    }

    private function validateREST($value) {
        $m = $this->message;

        $valid = $this->elements[$this->row]['valid'];

        if (!in_array($value, $valid))
            return $this->showValidation($m . _('possui conteúdo inválido.'));

        return $this->showValidation();
    }

    public function validateElements() {
        foreach($this->elements as $k=>$element):
            $this->row = $k;
            $this->field = $element['name'] . ' ';
            $this->message = _('O campo ') . $element['name'] . ' ';
            $this->valtype = $element['type'];
            $force = $element['force'];
            $value = $element['value'];
			$error = '';
            if ($force == 0 && empty($value)):
                $error = $this->showValidation();
            elseif($force == 1 && (empty($value) || ($element['type']=='file' && $value['size']=='0'))):
				$error = $this->showValidation(_('O campo ') . $this->field . _('é obrigatório.'));
            else:
				$function = strtoupper($this->valtype);
				$function = 'validate' . $function;
				$error = $this->$function($value);
			endif;
			if(!empty($error))$this->errors[$k] = $error;
        endforeach;
		if(count($this->elements) < 1)	$this->errors[0] = 'Não existe nenhum elemento a ser validado.';
		
		$this->errors_in_validation = implode('|',$this->errors);
        return $this->errors;
    }
	
	public function globalErro() {
		if(isset($this->errors[0])) return $this->errors[0]; else return '';
	}
	
	public static function model($object)
	{
		$validation = new Validate("specific","production","pt_BR");
		$itens = array();
		$CArray = CObject::toArray($object);
		foreach($CArray as $k=>$v):
			if(!is_array($v) && !is_object($v) && substr($k,0,2) != '__'):
				$type = $object->getType($k);
				$label = $object->getLabel($k);
				if($type):
					$itens[$k] = array("value" => html_entity_decode($v),"type" => $type, "name" =>$label,"force" => "1");
				endif;
			endif;
		endforeach;
		
		$validation->addArray($itens);
		$validation->validateElements();
		return $validation;
	}
}

?>