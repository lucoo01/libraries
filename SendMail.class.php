<?php
/**
 * author: loen.wang email:425389019@qq.com
 * date:2017-06-07
 * eg:
 * 	$info = [
 * 		'from' => '',
		'fromName' => '邮件消息',
		'to' => 'yepiaohuang@sina.com',
		'subject' => '标题',
		'html' => '这里存放html',
		'useAddressList'=>'true', //是否使用地址列表
 * 	];
 *  $mail = new SendMail( $info );
 *  $mail->send_mail();
 */
class SendMail {

	var $info = [
			'from' => '',
			'fromName' => '邮件消息',
			'to' => 'yepiaohuang@sina.com',
			'subject' => '标题',
			'html' => '这里存放html',
			'useAddressList'=>'true', //是否使用地址列表
	];
	
	function __construct( $info = [] ){
		if( empty($info) ) {
			die("请传入邮件信息!");
		}
		$this->info = $info;

	}

    function send_mail() {
      return $this->sendcloud();
  	}

  	/**
  	 * sendcloud 平台的邮件接口
  	 * @return [type] [description]
  	 */
  	function sendcloud() {
		$url = 'http://api.sendcloud.net/apiv2/mail/send';
		$API_USER = '';
		$API_KEY = '';

		//您需要登录SendCloud创建API_USER，使用API_USER和API_KEY才可以进行邮件的发送。
		$param = [
		  'apiUser'     => $API_USER,
		  'apiKey'      => '',
		  'from'        => $this->info['from'],
		  'fromName'    => $this->info['fromName'],
		  'to'          => $this->info['to'],
		  'subject'     => $this->info['subject'],
		  'html'        => $this->info['html'],
		  'respEmailId' => 'true',
		  'useAddressList'=>$this->info['useAddressList'],
		  ];

		$data = http_build_query($param);

		$options = [
		  'http' => [
		  'method'  => 'POST',
		  'header'  => 'Content-Type: application/x-www-form-urlencoded',
		  'content' => $data
			]
		];

		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);

		return $result;
  	}

}