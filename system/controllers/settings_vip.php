
<?php

	
	if( !$this->network->id ) {
		$this->redirect('home');
	}
	if( !$this->user->is_logged ) {
		$this->redirect('signin');
	}
	$D->submit = true;
	$D->error = true;
	$D->errmsg = "";
	$this->load_langfile('inside/global.php');
	$this->load_langfile('inside/settings.php');
	
	$D->page_title	= $this->lang('settings_profile_pagetitle', array('#SITE_TITLE#'=>$C->SITE_TITLE));
	
	include_once('helpers/lib/nusoap.php');
$D->doreha = array('one'=>'یک ماهه','tree'=>'سه ماهه','six'=>'شش ماهه','tw'=>'یک ساله');
	$D->boxes = $this->network->get_box_vips();
	
	if($this->param('from') == "ajax" && isset($_POST['id']) && isset($_POST['priud']) ){
$vid= intval($_POST['id']);
$prd = trim($_POST['priud']);
	if($this->network->get_user_vip_by_id($vid,$this->user->id)){
	echo 'ERROR"';

	echo 'قبلا خریداری شده است';
		return;
	}
	if(!$baste = $this->network->get_vips_by_id($vid)){
		echo 'ERROR:';
	echo 'چنین بسته ای مجود نیست';
	return;
	}
    
	
	$sabad =  new stdClass;
	
	$sabad->vipname = $baste->name;
	$sabad->vipid = $baste->id;
	$sabad->vipprd = $prd;
	$sabad->vipamount = $baste->$prd;
	$sabad->vipuser =$this->user->id;
	$sabad->viprand = md5(time().rand(0,100000).$this->user->info->username.$baste->name);
	$sabad->viptrak= '';
	$sabad->vipdate= time();
	$this->user->sess['VIP_SABAD'][$baste->name] = $sabad;
	
	echo $baste->title.' به سبد خرید اضافه شد';
	return;
	}
	if($this->param('from') == "ajax" && isset($_POST['name']) && $this->param('delsabad') == $_POST['name'] ){
	
	$this->user->sess['VIP_SABAD'][$_POST['name']] = false;
	unset($this->user->sess['VIP_SABAD'][$_POST['name']]);
	echo 'OK';
	return;
	
	
	}
if($this->param('from') == "pay" && isset($_GET['rand'])  ){
if(empty($this->user->sess['VIP_SABAD'])){
$D->error = true;
$D->errmsg .= 'سبد خرید شما خالیست';
	
	$this->load_template('settings_vip.php');
	return;
}
$D->bv = $this->user->sess['VIP_SABAD'];
$this->load_template('settings_vip-pay.php');
	return;



}	
if( isset($_POST['pay_vip_last'])  &&  $_POST['rand2'] == $this->param('from') ){

if(empty($this->user->sess['VIP_SABAD'])){
$D->error = true;
$D->errmsg .= 'سبد خرید شما خالیست';
	
	$this->load_template('settings_vip.php');
	return;
}

$MerchantID= 'XXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXXXX';
//$res = 'ew9843884-edrere-erwevcge453-dfsdfgf';

$Amount = intval($_POST['amount']);	
$Description = 'خرید بسته ویژه';  // Required
$Email = $this->user->info->email; // Optional
	$Mobile =''; // Optional
	$CallbackURL = $C->SITE_URL.'settings/vip';
	$client = new nusoap_client('https://de.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl'); 
	$client->soap_defencoding = 'UTF-8';
	$result = $client->call('PaymentRequest', array(
													array(
															'MerchantID' 	=> $MerchantID,
															'Amount' 		=> $Amount,
															'Description' 	=> $Description,
															'Email' 		=> $Email,
															'Mobile' 		=> $Mobile,
															'CallbackURL' 	=> $CallbackURL
														)
													)
	);
	if($result['Status'] == 100)
	{
	
	$this->user->sess['VIP_USER_RES'] = $result['Authority'];
		$this->user->sess['VIP_SABAD']['amount'] = intval($_POST['amount']);
	$this->user->sess[$result['Authority']] = $this->user->sess['VIP_SABAD'];

	//Redirect to URL You can do it also by creating a form
	$this->redirect('https://www.zarinpal.com/pg/StartPay/'.$result['Authority']);
	
	
	

		
		
	} else {
		echo'ERR: '.$result['Status'];
	}
	
	//$this->redirect($callBackUrl.'?au='.$res);

	
	


}

if(isset($_GET['Authority']) && isset($this->user->sess['VIP_USER_RES']) && $_GET['Authority'] == $this->user->sess['VIP_USER_RES']){




$basteha = $this->user->sess[$_GET['au']];

$MerchantID = 'XXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXXXX';
$Authority = $this->user->sess['VIP_USER_RES'];
$au =$Authority;
$basteha = $this->user->sess[$au];
$Amount = $amount =	$basteha['amount'];
$pri = 	$basteha['pri'];
$trak = 	'';//$_GET['refID'];

$client = new nusoap_client('https://de.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl'); 
		$client->soap_defencoding = 'UTF-8';
		$result = $client->call('PaymentVerification', array(
															array(
																	'MerchantID'	 => $MerchantID,
																	'Authority' 	 => $Authority,
																	'Amount'	 	 => $Amount
																)
															)
		);
		
		



if(trim($result['Status']) !== '100'){
			echo 'ERR';
			return;
		}

$trak = $result['RefID'];
$T = array();
$date = time();
$next_d = array('one'=>60*60*24*30,'tree'=>60*60*24*90,'six'=>60*60*24*180,'tw'=>60*60*24*320);
foreach($basteha as $t=>$vl){
if($t !== 'amount' && $n = $this->network->get_vips_by_name($t)){
$sarresid = $next_d[$vl->vipprd]+$date;
$db2->query('INSERT INTO users_vip SET 
user_id="'.$vl->vipuser.'",
vip_id="'.$n->id.'",
vip_name="'.$n->name.'",
vip_p="'.$vl->vipprd.'",
date="'.$date.'",
next_date= "'.$sarresid.'" ,
rkey="'.$vl->viprand.'",
trak="'.$trak.'",
amount="'.$vl->vipamount.'"

');
$this->network->get_user_vip_by_id($n->id,$vl->vipuser,true);


}



}

unset($this->user->sess['VIP_USER_RES']);
unset($this->user->sess[$_GET['au']]);
unset($this->user->sess['VIP_SABAD']);
$this->redirect('settings/vip');
}	

	$this->load_template('settings_vip.php');
	
?>