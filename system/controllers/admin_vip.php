<?php
	/*
	CREATE TABLE `box_vips` (
`id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
`name` VARCHAR( 255 ) NOT NULL ,
`title` VARCHAR( 255 ) NOT NULL ,
`one` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`tree` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`six` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`tw` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
`active` SMALLINT( 1 ) UNSIGNED NOT NULL DEFAULT '0',
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;


	*/
	if( !$this->network->id ) {
		$this->redirect('home');
	}
	if( !$this->user->is_logged ) {
		$this->redirect('signin');
	} 
	$db2->query('SELECT 1 FROM users WHERE id="'.$this->user->id.'" AND  is_network_admin="1" LIMIT 1');
	if( 0 == $db2->num_rows() ) {
		$this->redirect('dashboard');
	}

	$this->load_langfile('inside/admin.php');
	$D->error = FALSE;
	$D->submit = FALSE;
	$D->errmsg = '';
	 $D->boxes = $this->network->get_box_vips();
	 $D->foredit = false;
if(isset($_POST['delete'])){

foreach($_POST['delete'] as $d){
$n = $this->network->get_vips_by_id(intval($d));
if(!$n){
continue;
}
if($num = $this->db2->fetch_field('SELECT COUNT(id) FROM users_vip WHERE  vip_id="'.$n->id.'"')){
$D->error = TRUE;
$D->errmsg .=$num." کاربر در حال استفاده از بسته ".$n->title." هستند و حذف نشدند <br>";
continue;
}
$db2->query('DELETE FROM box_vips WHERE id="'.intval($d).'"');
$D->boxes = $this->network->get_box_vips(TRUE);
 unset($_POST);
$D->submit = TRUE;


}

}
/////////////////////////////////////////////////////////////////////////////////	
if(isset($_POST['sbm'])){

$name = trim($_POST['name']);
$title = trim($_POST['title']);
$one = intval($_POST['one']);
$tree = intval($_POST['tree']);
$six = intval($_POST['six']);
$tw = intval($_POST['tw']);
$active = ( isset($_POST['active']) ? 1 : 0 );
if( !$title)  {

			$D->error	= TRUE;

			$D->errmsg	.= 'برای عنوان یک متن مناسب انتخاب کنید <br>';

		}
if( !preg_match('/^[a-z0-9\-\_]{1,30}$/iu', $name) ) {

$D->error	= TRUE;
$D->errmsg	.= 'نام یکتا باید انگلیسی باشد <br>';

		}
if( ($one < 0 && $one < 1000) ||($six < 0 && $six < 1000) ||($tree < 0 && $tree < 1000) ||($tw < 0 && $tw < 1000)   ){
$D->error	= TRUE;
$D->errmsg	.= 'قیمت یا یا باید 0 یا بیشتر از 1000 باشد <br>';

}
if( $db2->fetch_field('SELECT COUNT(id) FROM box_vips WHERE name="'.$name.'"') > 0){
$D->error	= TRUE;
$D->errmsg	.= 'این نام یکتا موجود میباشد<br>';
 
}
if(!$D->error){		
$db2->query('INSERT INTO box_vips SET name="'.$name.'", title="'.$title.'", one="'.$one.'", tree="'.$tree.'", six="'.$six.'", tw="'.$tw.'" ,active="'.$active.'" ');
 $inid = $db2->insert_id();		

 $D->boxes = $this->network->get_box_vips(TRUE);
 unset($_POST);
$D->submit = TRUE;
		
}
}
	?>

<? if( $this->param('edit') ){

if( $v = $this->network->get_vips_by_id(intval($this->param('edit')))){


$D->foredit = true;

	if(isset($_POST['edit_vip_'.$v->id])){
	$title = trim($_POST['title']);
$one = intval($_POST['one']);
$tree = intval($_POST['tree']);
$six = intval($_POST['six']);
$tw = intval($_POST['tw']);
$active = ( isset($_POST['active']) ? 1 : 0 );
if( !$title)  {

			$D->error	= TRUE;

			$D->errmsg	.= 'برای عنوان یک متن مناسب انتخاب کنید <br>';

		}

if( ($one < 0 && $one < 1000) ||($six < 0 && $six < 1000) ||($tree < 0 && $tree < 1000) ||($tw < 0 && $tw < 1000)   ){
$D->error	= TRUE;
$D->errmsg	.= 'قیمت یا یا باید 0 یا بیشتر از 1000 باشد <br>';

}

if(!$D->error){		
$db2->query('UPDATE  box_vips SET  title="'.$title.'", one="'.$one.'", tree="'.$tree.'", six="'.$six.'", tw="'.$tw.'" ,active="'.$active.'" WHERE id="'.$v->id.'" LIMIT 1 ');
 $inid = $db2->insert_id();		
$v = $this->network->get_vips_by_id($v->id,TRUE);
 $D->boxes = $this->network->get_box_vips(TRUE);
 unset($_POST);
$D->submit = TRUE;
		
}
	
	
	} 
	 


?>
<html dir="rtl">
<head>
<link rel="stylesheet" type="text/css" media="screen" href="<?= $C->SITE_URL?>themes/<?=$C->THEME?>/css/css-table.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?= $C->SITE_URL?>themes/<?=$C->THEME?>/css/inside.css" />
<script type="text/javascript" src="<?= $C->SITE_URL.'themes/'.$C->THEME ?>/js/jquery-1.9.0.min.js"></script>
<script type="text/javascript"> 
<? if($D->submit){ ?>
opener.document.getElementById('td_vip_title_<?=$v->id?>').innerHTML = '<?=$v->title?>';
opener.document.getElementById('td_vip_one_<?=$v->id?>').innerHTML = '<?=$v->one?>';
opener.document.getElementById('td_vip_tree_<?=$v->id?>').innerHTML = '<?=$v->tree?>';
opener.document.getElementById('td_vip_six_<?=$v->id?>').innerHTML = '<?=$v->six?>';
opener.document.getElementById('td_vip_tw_<?=$v->id?>').innerHTML = '<?=$v->tw?>';
opener.document.getElementById('td_vip_active_<?=$v->id?>').innerHTML = "<?= $v->active ? '<b style=\"color:green\">فعال</b>' : '<b style=\"color:red\">غیر فعال</b>' ?>"
self.close();
  

<? }?>
</script>
</head>
<body>
<script type="text/javascript" src="<?= $C->SITE_URL?>themes/<?=$C->THEME?>/js/style-table.js"></script>
			<div class="greygrad" style="margin-top:5px;">
								<div class="greygrad2">
									<div class="greygrad3" style="padding-top:0px;">
										<form method="post" action="">
											<table id="setform" cellspacing="5">
												<tr>
													<td class="setparam">نام یکتا</td>
													<td><?= $v->name?></td>
													
												</tr>
												<tr>
													<td class="setparam">عنوان نمایشی</td>
													<td><input placeholder="به پارسی هم میتوانید انتخاب کنید" type="text" name="title" value="<?= $v->title?>" class="setinp" maxlength="50" /></td>
													
												</tr>
												<tr>
													<td class="setparam">قیمت(ماه)</td>
													<td>1<input  placeholder="یک ماهه" type="text" name="one" value="<?= $v->one?>" class="setinp" style="width:15%" maxlength="50" />
													3<input placeholder="سه ماهه" type="text" name="tree" value="<?= $v->tree?>" class="setinp" style="width:15%" maxlength="50" />
													6<input placeholder="شش ماهه" type="text" name="six" value="<?= $v->six?>" class="setinp" style="width:15%" maxlength="50" />
													12<input placeholder="یک ساله" type="text" name="tw" value="<?= $v->tw?>" class="setinp" style="width:15%" maxlength="50" /> 
													تومان (0 برای غیر فعالی دوره)
													</td>
													
												</tr>
			
			                                             <tr>
													<td class="setparam">فعال</td>
													<td><input type="checkbox" name="active" <?= $v->active ? 'checked="checked"' : ''?> value="1"  maxlength="50" />
													
													</td>
													
												</tr>
												  <tr>
													<td class="setparam"></td>
													<td><input onclick="updateParent()" type="submit" name="<?='edit_vip_'.$v->id?>" value="ویرایش بسته"   />
													
													</td>
													
												</tr>
												
												
											</table>
											
													</form>
									</div>
								</div>
							</div>	
</body>
</html>							


<?
     return;      
	 
	 
	 

	 
	 
	 
	 
	 
	 }else{
$D->foredit = false;


	}


}
?>
	<?
	$this->load_template('admin_vip.php');
	
?>