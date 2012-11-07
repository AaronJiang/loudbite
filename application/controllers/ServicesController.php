<?php
/*
 * ServiceController.php
 * 
 * @auther
 */
class ServicesController extends Zend_Controller_Action
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
     * Display all the artists in the system
     */
	public function getartistsAction()
	{
		require_once "../application/models/Services/WebServices.php";
		$server = new Zend_Rest_Server();
		$server->setClass('WebServices');
		$server->handle(array('method' => 'getArtists'));
		
		$this->_helper->viewRenderer->setNoRender();
	}
	    

}

