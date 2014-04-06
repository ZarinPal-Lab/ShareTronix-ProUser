<?php
	
	$this->load_template('header.php');
	
?>
<link rel="stylesheet" type="text/css" media="screen" href="<?= $C->SITE_URL?>themes/<?=$C->THEME?>/css/css-table.css" />
<script type="text/javascript" src="<?= $C->SITE_URL?>themes/<?=$C->THEME?>/js/style-table.js"></script>
					<div id="settings">
						<div id="settings_left">
							<?php $this->load_template('admin_leftmenu.php') ?>
						</div>
						<div id="settings_right">
							<div class="ttl">
								<div class="ttl2">
									<h3>بسته های VIP</h3>
								</div>
							</div>
							<?php if($D->error) { ?>
							<?= errorbox($this->lang('admgnrl_error'), $D->errmsg, TRUE, 'margin-top:5px;margin-bottom:5px;') ?>
							<?php } elseif($D->submit) { ?>
							<?= okbox($this->lang('admgnrl_okay'), 'انجام شد', TRUE, 'margin-top:5px;margin-bottom:5px;') ?>
							<?php } ?>
					
							<div class="greygrad" style="margin-top:5px;">
								<div class="greygrad2">
									<div class="greygrad3" style="padding-top:0px;">
										<form method="post" action="">
											<table id="setform" cellspacing="5">
												<tr>
													<td class="setparam">نام یکتا</td>
													<td><input placeholder="به لاتین انخاب کنید"  type="text" name="name" value="" class="setinp" maxlength="50" /></td>
													
												</tr>
												<tr>
													<td class="setparam">عنوان نمایشی</td>
													<td><input placeholder="به پارسی هم میتوانید انتخاب کنید" type="text" name="title" value="" class="setinp" maxlength="50" /></td>
													
												</tr>
												<tr>
													<td class="setparam">قیمت(ماه)</td>
													<td>1<input  placeholder="یک ماهه" type="text" name="one" value="0" class="setinp" style="width:15%" maxlength="50" />
													3<input placeholder="سه ماهه" type="text" name="tree" value="0" class="setinp" style="width:15%" maxlength="50" />
													6<input placeholder="شش ماهه" type="text" name="six" value="0" class="setinp" style="width:15%" maxlength="50" />
													12<input placeholder="یک ساله" type="text" name="tw" value="0" class="setinp" style="width:15%" maxlength="50" /> 
													تومان (0 برای غیر فعالی دوره)
													</td>
													
												</tr>
			
			                                             <tr>
													<td class="setparam">فعال</td>
													<td><input type="checkbox" name="active" value="1"  maxlength="50" />
													
													</td>
													
												</tr>
												  <tr>
													<td class="setparam"></td>
													<td><input type="submit" name="sbm" value="ساخت بسته"   />
													
													</td>
													
												</tr>
												
												
											</table>
											
													</form>
									</div>
								</div>
							</div>		
											
		<? if(!empty($D->boxes)){ ?>					
<table id="travel" >

	
    
    <thead>    

        
        <tr>
            <th scope="col"><input onclick="toggle(this);" type="checkbox" name="selecct_all" id="selecct_all" value="1"/></th>
            <th scope="col">کد یکتا</th>
            <th scope="col">نام یکتا</th>
            <th scope="col">عنوان</th>
            <th scope="col">یک ماهه</th>
            <th scope="col">سه ماهه</th>
            <th scope="col">شش ماهه</th>
            <th scope="col">یک ساله</th>
            <th scope="col">وضعیت</th>
            <th scope="col">ویرایش</th>
            <th scope="col">دریافت کد</th>
        </tr>        
    </thead>
    
 
    
    <tbody>
	
    	<script>

function toggle(source) {
  checkboxes = document.getElementsByName('delete[]');

  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>	
		
		
		
    	<? foreach($D->boxes as $v){ ?>
		
			<form method="post" action="">
		
		<tr >
		  <td  scope="col"><input type="checkbox"  name="delete[]" id="instance" value="<?= $v->id?>"/></td>
		  <td    scope="col"><?= $v->id?></td>
            <td     id="td_vip_name_<?=$v->id?>" scope="col"><?= $v->name ?></td>
            <td  id="td_vip_title_<?=$v->id?>"  scope="col"><?= $v->title ?></td>
            <td  id="td_vip_one_<?=$v->id?>"  scope="col"><?= $v->one  ? $v->one : 'غیر فعال' ;?></td>
            <td  id="td_vip_tree_<?=$v->id?>"   scope="col"><?= $v->tree ? $v->tree  : 'غیر فعال' ?></td>
            <td  id="td_vip_six_<?=$v->id?>"  scope="col"><?= $v->six ?   $v->six : 'غیر فعال' ?></td>
            <td  id="td_vip_tw_<?=$v->id?>"   scope="col"><?= $v->tw  ? $v->tw : 'غیر فعال' ?></td>
            <td  id="td_vip_active_<?=$v->id?>"   scope="col"><?= $v->active ? '<b style="color:green">فعال</b>' : '<b style="color:red">غیر فعال</b>' ?></th>
		<td scope="col"><a href="javascript:;" onclick="NewWindow ('<?= $C->SITE_URL ?>admin/vip/edit:<?= $v->id ?>','edit','700','380','center','front');" ><img src="<?= $C->SITE_URL?>themes/<?=$C->THEME?>/imgs/pctrls_edit.gif" /></a></td>
		<td scope="col">
<?php $code = '&lt;? if($this->network->valid_vip('.$v->id.',USER_ID)){?&gt;کد های مورد نمایش&lt;?}?&gt;' ;
 $code = htmlspecialchars($code);
?>
<a href="javascript:;" onclick="flybox_open('600', '230', 'کد برای <?= $v->name?>', '<div dir=\'ltr\' style=\'padding:10px;text-align:left\'><?= $code?></div>')"	>دریافت کد</a>	
		</td>
			</tr>
		<?} ?>
        <tr >
		<th><input type="submit" name="delete_sbm" value="حذف انتخاب شده ها" /> </th>
		  <th scope="col">کد یکتا</th>
            <th scope="col">نام یکتا</th>
            <th scope="col">عنوان</th>
            <th scope="col">یک ماهه</th>
            <th scope="col">سه ماهه</th>
            <th scope="col">شش ماهه</th>
            <th scope="col">یک ساله</th>
            <th scope="col">وضعیت</th>
            <th scope="col">ویرایش</th>
            <th scope="col">دریافت کد</th>
		</tr>
     </form>
    </tbody>

</table>

			
	<? } ?>										
											
											
		

				
								
											
					
							
						</div>
					</div>
<?php
	
	$this->load_template('footer.php');
	
?>