<?php
/**
 * Search Controller
 * @author root
 *
 */
class SearchController extends Zend_Controller_Action
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
     * Create Index
     * 
     */
    public function createIndexAction()
    {
    	//Create an index
    	$Index = Zend_Search_Lucene::create("../application/searchindex");
    	
    	echo "index created";
    	
    	//Supress the view
    	$this->_helper->viewRenderer->setNoRender();
    }


}

