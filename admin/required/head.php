<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />

<?php $js = H::js();?>
<?php $css = H::css();?>

<script type="text/javascript">
var BASE_URL = '<?php echo H::site();?>';
var ROOT = '<?php echo H::root();?>';
var URI = '<?php echo $_SERVER['REQUEST_URI'];?>';
var newDate = new Date;
</script>
<?php foreach($js as $v):?>
<?php $arquivo_js = substr_count($v, '://') > 0 ?  $v : H::root().'js/'.$v;?>
<script src="<?php echo $arquivo_js;?>" type="text/javascript"></script>
<?php endforeach;?>

<?php foreach($css as $v):?>
<?php $arquivo_css = substr_count($v, '://') > 0 ?  $v : H::root().'css/'.$v;?>
<link href="<?php echo $arquivo_css;?>" rel="stylesheet" type="text/css">
<?php endforeach;?>

<link rel="shortcut icon" href="<?php echo H::root();?>imagens/favicon.png" type="image/x-icon"/>
<link rel="icon" href="<?php echo H::root();?>imagens/favicon.png" type="image/gif" />
<title><?php echo H::title();?></title>