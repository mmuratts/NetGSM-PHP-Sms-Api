<?php
## NETGSM SMS APİ V1
## Created By Murat Çeşme
## www.muratcesme.com
## 21.01.2018
class SendSMS
{
	public $username;
	public $password;
	public $header;
	public $message;
	public $phone;
	protected $return;


	public function XMLPOST($PostAddress,$xmlData)
	{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$PostAddress);
	//		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);
			$result = curl_exec($ch);
			return $result;
	}
	public function send()
	{
		$xml='<?xml version="1.0" encoding="UTF-8"?>
	<mainbody>
		<header>
			<company>NETGSM</company>
	        <usercode>'.$this->username.'</usercode>
	        <password>'.$this->password.'</password>
			<startdate></startdate>
			<stopdate></stopdate>
		    <type>1:n</type>
	        <msgheader>'.$this->header.'</msgheader>
	        </header>
			<body>
			<msg><![CDATA['.$this->message.']]></msg>
			<no>90'.$this->phone.'</no>
			</body>
	</mainbody>';
		$this->return = $this->XMLPOST('http://api.netgsm.com.tr/xmlbulkhttppost.asp',$xml);
		
		$this->returnSuccess = substr($this->return, 0,2);
		$this->bulkid = substr($this->return, 3,9);
		if($this->returnSuccess == "00")
			echo "SMS Başarıyla Gönderildi. Gönderim Sorgulama : ".$this->bulkid;
	}

}
$sms = new SendSMS;
$sms->username = "kullanıcı adınız";
$sms->password = "şifreniz";
$sms->header = "sms başlığınız";
$sms->message = "sms içeriği";
$sms->phone = "gönderilecek telefon numarası";
$sms->send();


