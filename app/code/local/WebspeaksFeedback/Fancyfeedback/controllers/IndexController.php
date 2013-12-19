<?php
class WebspeaksFeedback_Fancyfeedback_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
		$fancyfeedbackTable = Mage::getSingleton('core/resource')->getTableName('fancyfeedback');
		
		$write = Mage::getSingleton("core/resource")->getConnection("core_write");
		$query = "insert into ".$fancyfeedbackTable." (name, email, comment, ip, created_time) values (:name, :email, :comment, :ip, NOW())";

		$binds = array(
			'name'      		=> ($_REQUEST['name'])?$_REQUEST['name']:'',
			'email'  		    => ($_REQUEST['email'])?$_REQUEST['email']:'',
			'comment'		    => ($_REQUEST['msg'])?$_REQUEST['msg']:'',
			'ip'	    		=> $this->getRealIpAddr(),
		);
		$write->query($query, $binds);


		//echo json_encode(array('value'=>'Thanks for your response!'));
		echo $this.__('Thanks for your response!');
		
		$this->sendMail($_REQUEST['email'], $_REQUEST['name'], Mage::getStoreConfig('fancyfeedbackconfig/fancyfeedback_group/fancyfeedback_subject'), $_REQUEST['msg']);
		die;
    }

    public function sendMail($email, $name, $subject='', $message='') {
        $sender = Array(
            'name'  => $name,
            'email' => $email
        );
        $receiver_email = Mage::getStoreConfig('fancyfeedbackconfig/fancyfeedback_group/fancyfeedback_receiveremail');
        $receiver_name = '';
        $mailSubject = Mage::getStoreConfig('fancyfeedbackconfig/fancyfeedback_group/fancyfeedback_subject');
        $templateId = Mage::getStoreConfig('fancyfeedbackconfig/fancyfeedback_group/fancyfeedback_email_template_new');
        $vars = Array('message' => $message);
        $storeId = Mage::app()->getStore()->getId();
        Mage::getModel('core/email_template')
            ->setTemplateSubject($mailSubject)
            ->sendTransactional($templateId, $sender, $receiver_email, $receiver_name, $vars, $storeId);
        $translate  = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(true);
    }
	
	public function getRealIpAddr()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
}