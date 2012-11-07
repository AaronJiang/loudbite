<?php

class TestController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    
    public function clientwsAction()
    {
    	$Client = new Zend_Rest_Client("http://".$_SERVER['HTTP_HOST']);
    	try
    	{
    		$results = $Client->get("services/getartists");
    		if($results->isSuccess()){
    			echo $results->getBody();
    		}
    	}
    	catch(Zend_Service_Exception $e)
    	{ 
    		throw $e; 
    	}
    	
    	//Suppress the view
    	$this->_helper->viewRenderer->setNoRender();
    }
    	 

}

