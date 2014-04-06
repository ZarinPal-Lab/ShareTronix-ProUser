<?php
	
	$this->load_template('header.php');

?>
<link rel="stylesheet" type="text/css" media="screen" href="<?= $C->SITE_URL?>themes/<?=$C->THEME?>/css/css-table.css" />
<script type="text/javascript" src="<?= $C->SITE_URL?>themes/<?=$C->THEME?>/js/style-table.js"></script>
<script>
function sabad_vip(valid){

var vform = d.forms['vip_'+valid];
var priud = vform.elements['vip_amount_'+valid].value;
var id = vform.elements['id_'+valid].value;
var name = vform.elements['name_'+valid].value;
var td = d.getElementById('sbm_'+valid);

var req = ajax_init(false);
	if( ! req ) { return; }
	req.onreadystatechange	= function() {
		if( req.readyState != 4  ) { return; }
		


	alert(req.responseText);
td.innerHTML = '<input style="color:red" onclick="sdel_vip(\''+name+'\',\''+valid+'\')" type="submit" value="حذف از سبد خرید" name="add_vip" />';
	 $('#sbm_'+valid+' input').css('cursor','pointer');
	vform.elements['vip_amount_'+valid].disabled = "disabled";
	
	}
	
	req.open("POST", siteurl+"settings/vip/from:ajax/id:"+id+"/r:"+Math.round(Math.random()*1000), true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	req.send("priud="+encodeURIComponent(priud)+"&id="+encodeURIComponent(id));
    $('#sbm_'+valid+' input').css('cursor','wait');
   



}

function sdel_vip(valid,idtd){

var td = d.getElementById('sbm_'+idtd);
var vform = d.forms['vip_'+idtd];
var req = ajax_init(false);
	if( ! req ) { return; }
	req.onreadystatechange	= function() {
		if( req.readyState != 4  ) { return; }
		//if( req.responseText != "OK" ) { alert('f') return; }


	alert('از سبد حذف شد');
td.innerHTML = '<input onclick="sabad_vip(\''+idtd+'\')" type="submit" value="افزودن به سبد خرید" name="add_vip" />';
	 $('#sbm_'+idtd+' input').css('cursor','pointer');
	 	vform.elements['vip_amount_'+idtd].disabled = "";
	}
	
	req.open("POST", siteurl+"settings/vip/from:ajax/delsabad:"+valid+"/r:"+Math.round(Math.random()*1000), true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	req.send("name="+encodeURIComponent(valid));
   $('#sbm_'+idtd+' input').css('cursor','wait');
   



}



</script>


					<div id="settings">
						<div id="settings_left">
							<?php $this->load_template('settings_leftmenu.php') ?>
					
					</div>
						<div id="settings_right">
							<div class="ttl">
								<div class="ttl2">
									<h3>بسته های VIP</h3>
								</div>
							</div>
					<? if(!empty($D->boxes)){ ?>
<table id="travel" >

	
    
    <thead>    

        
        <tr>
          
   
       
           
            <th scope="col">عنوان</th>
            <th scope="col">بسته</th>
            <th scope="col">خرید</th>
        </tr>        
    </thead>
    
 
    
    <tbody>					
					<? foreach($D->boxes as $b){  if($b->active && !$nv = $this->network->get_user_vip_by_id($b->id,$this->user->id) ){   $nist = false;?>
				
<form action="<?= $C->SITE_URL?>settings/vip/from:ajax/name:<?= $b->name?>/id:<?= $b->id?>"  method="post" onsubmit="return false;"  name="vip_<?= $b->name.'_'.$b->id?>">
		
		<tr >

		  <td    scope="col"><?= $b->title?></td>
          
      
            <td   scope="col">
			<input type="hidden" name="id_<?= $b->name.'_'.$b->id?>" value="<?= $b->id?>" />
			<input type="hidden" name="name_<?= $b->name.'_'.$b->id?>" value="<?= $b->name?>" />
			<select <?= !empty($this->user->sess['VIP_SABAD'][$b->name]) ? 'disabled="disabled"' : '' ?> name="vip_amount_<?= $b->name.'_'.$b->id?>" >
			<? if($b->one > 0 && $b->one >=1000 ){ ?>
			<option value="one" >یک ماهه :<?=$b->one?> تومان </option>
			<?}?>
			<? if($b->tree > 0 && $b->tree >=1000 ){ ?>
			<option value="tree" >سه ماهه :<?=$b->tree?> تومان </option>
			<?}?>
			<? if($b->six > 0 && $b->six >=1000 ){ ?>
			<option value="six" >6ماهه :<?=$b->six?> تومان </option>
			<?}?>
			<? if($b->tw > 0 && $b->tw >=1000 ){ ?>
			<option value="tw" >ا ساله :<?=$b->tw?> تومان </option>
			<?}?>
			</select>
			</td>
             <td  id="sbm_<?= $b->name.'_'.$b->id?>" scope="col">
			<? if(empty($this->user->sess['VIP_SABAD'][$b->name])){ ?>
			 <input onclick="sabad_vip('<?= $b->name.'_'.$b->id?>')" type="submit" value="افزودن به سبد خرید" name="add_vip" />
			<?}else{?>
			 <input style="color:red" class="uibutton" onclick="sdel_vip('<?= $b->name?>','<?= $b->name.'_'.$b->id?>')" type="submit" value="حذف از سبد خرید" name="dell_vip" />
			
			<? } ?>
			</td>
          
			</tr>
</form>			
		
    
		
		  <? }elseif($nv = $this->network->get_user_vip_by_id($b->id,$this->user->id)){
		
		   echo '  <tr><td>'.$b->title.'</td> ';
		   echo '  <td>'.$D->doreha[$nv->vip_p].'</td>  ';
		   echo '  <td s>خرید شده است | <b  style="direction:ltr;text-align:left"> '.pdate('y/m/d',$nv->date).' تا '.pdate('y/m/d',$nv->next_date).'</b></td>  </tr>';
		   $nist = true;
		  
		  } }?>
		
		

		
		<tfoot>
		   <tr >
		
		 <th scope="col">عنوان</th>
         <th scope="col">بسته</th>
		 <? if(1==1){?>
		 <form action="<?= $C->SITE_URL?>settings/vip/from:pay"  method="get" >
	<input type="hidden" name="rand" value="<?= md5(rand(0,1000000))?>"/>
         <th scope="col"><input type="submit" name="pay_vip" value="گام بعدی" /></th>
		 </form>
		 <?}else{
		   echo '<th>بسته ای وجود ندارد</th>';
		   $nist = true;
		  
		  }?>
		</tr>
		</tfoot>
    
    </tbody>

</table>

		
  <? } ?>					
					
					
	
<? $factor = $this->network->get_user_vip($this->user->id); ?>

<? if(!empty($factor)){ ?>
	<div class="ttl">
								<div class="ttl2">
									<h3>فاکتور های من</h3>
								</div>
							</div>

<table id="travel" >

	
    
    <thead>    

        
        <tr>
          
   
        <th scope="col">شماره فاکتور</th>
            <th scope="col">عنوان</th>
            <th scope="col">فاکتور</th>
            <th scope="col">سررسید</th>
            <th scope="col">پرداختی</th>
            <th scope="col">کد پرداخت</th>
        </tr>        
    </thead>
    
 
    
    <tbody>		

<? $i = 0 ;foreach($factor as $f){ 	if($n = $this->network->get_vips_by_id($f->vip_id)){  $i= $i+$f->amount;?>
	
		<tr >

<td    scope="col">#<?= $f->id?></td>
<td    scope="col"><?= $n->title?></td>
<td   scope="col"><?= pdate('y/m/d',$f->date) ?></td>
<td scope="col"><b style="color:red"><?= pdate('y/m/d',$f->next_date)?> </b></td>
<td scope="col"><?= $f->amount?> </td>
<td scope="col"><?= $f->trak?> </td>
          
			</tr>
			
		

		
		  <? } }?>
		
		

		
		<tfoot>
		   <tr >
		
		       <th scope="col">شماره فاکتور</th>
            <th scope="col">عنوان</th>
            <th scope="col">فاکتور</th>
            <th scope="col">سررسید</th>
            <th scope="col"><?= $i?></th>
            <th scope="col">کد پرداخت</th>
		</tfoot>
   
    </tbody>

</table>

<?}?>
	
					
					
					
					
					
					
					
					
							
						
					</div></div>
					















					
					
<?php
	
	$this->load_template('footer.php');
	
?>