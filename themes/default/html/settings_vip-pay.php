<?php
	
	$this->load_template('header.php');

?>
<link rel="stylesheet" type="text/css" media="screen" href="<?= $C->SITE_URL?>themes/<?=$C->THEME?>/css/css-table.css" />
<script type="text/javascript" src="<?= $C->SITE_URL?>themes/<?=$C->THEME?>/js/style-table.js"></script>
<?if(!empty($D->bv)){?>

<table id="travel" >

	
    
    <thead>    

        
        <tr>
          
   
       
            <th scope="col">عنوان</th>
            <th scope="col">دوره</th>
            <th scope="col">مبلغ</th>
        </tr>        
    </thead>
    
 
    
    <tbody>					
					<? $i=0;foreach($D->bv as $b){  $v = $this->network->get_vips_by_name($b->vipname); ?>
	
		<tr >

<td    scope="col"><?= $v->title?></td>
<td   scope="col"><?= $D->doreha[$b->vipprd] ?></td>
<td scope="col"><b style="color:red"><?= $b->vipamount?> تومان </b></td>
          
			</tr>
			
		
   <? $i = $i + $b->vipamount ?>
		
		  <? } ?>
		
		

		
		<tfoot>
		   <tr >
		
		 <th scope="col">عنوان</th>
         <th scope="col">بسته</th>
		 <form action="<?= $C->SITE_URL?>settings/vip/from:<?= $_GET['rand']?>"  method="post" >
	<input type="hidden" name="rand2" value="<?= $_GET['rand']?>"/>
	<input type="hidden" name="amount" value="<?= $i?>"/>
         <th scope="col">
		 <input type="submit" name="pay_vip_last" value="پرداخت نهایی <?=$i ?> تومان" />
		 <a   class="uibutton" href="<?= $C->SITE_URL?>settings/vip/"  >بازگشت به سبد خرید </a>
		 </th>
		 </form>
		</tr>
		</tfoot>
     </form>
    </tbody>

</table>

<? } ?>
	



	
<?php
	
	$this->load_template('footer.php');
	
?>