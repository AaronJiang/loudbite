<?php
/**
 * Email controller.
 * 
 * @author Aaron
 * @package Beginning_Zend_Framework
 *
 */
class EmailController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

	/**
	 * Basic example using default settings
	 */
    public function smtpSendMailAction()
    {
    	//Create SMTP connection Object
    	$configInfo = array('auth' => 'login',
    				'ssl' => 'ssl',
    				'username' => 'aaron.jijesoft@gmail.com',
    				'password' => 'jijesoft',
    				'port' => '465');
    	$smtpHost = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $configInfo);
    	
     	//Create Zend_Mail object
     	$MailObj = new Zend_Mail();
     	$emailMessage = "hi, send from zend_mail";
     	
     	//Read image data
     	$fileLocation = "/var/redrome.jpg";
     	if (!$fileHandler = fopen($fileLocation,'rb')) 
     	{
     		throw new Exception("file could not be found");
     	}
     	$fileContent = fread($fileHandler, filesize($fileLocation));
     	fflush($fileHandler);
     	fclose($fileHandler);
     	
     	$fromEmail = "aaron.jijesoft@gmail.com";
     	$fromFullName = "Aaron Jiang";
     	$to = "aaron.jijesoft@gmail.com";
     	$subject = "Zend mail";
    	
     	//Check if email is valid
     	$validator = new Zend_Validate_EmailAddress(
     				Zend_Validate_Hostname::ALLOW_DNS,
	     			true);
     	
     	if($validator->isValid($to))
     	{
     		$MailObj->setBodyText($emailMessage);
     		$MailObj->setFrom($fromEmail,$fromFullName);
     		$MailObj->addTo($to);
     		$MailObj->setSubject($subject);
     		$MailObj->createAttachment($fileContent,
     				'jpg',
     				Zend_Mime::DISPOSITION_ATTACHMENT);
     		
     		try
     		{
     			$MailObj->send($smtpHost);
     			echo "mail sent successfully";
     		}
     		catch(Zend_Mail_Exception $e)
     		{
     			echo $e->getMessage();
     		}
     	}	
	    else
	    {
	    	$messages = $validator->getMessages();
	    	foreach($messages as $message)
	    	{
	    		echo $message.'<br/>';
	    	}
	    }	 	
   	
     	//Supress the view
     	$this->_helper->viewRenderer->setNoRender();
    }
}

