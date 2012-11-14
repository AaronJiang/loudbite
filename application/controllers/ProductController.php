<?php

class ProductController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	//Get the artist name from the request
    	$artistName = $this->_request->getParam("artistName");

    	if(empty($artistName))
    	{
    		throw new Exception("Oh man i think you broke something. 
    			No not really, you just got here by mistake.");
    	}	

    	try
    	{
    		$amazon = new Zend_Service_Amazon('AKIAJI6PH75BYC7SO7JA','US',
    							'fARC6sT+cgQHF+H84NNGH/tNLiXwtB0hU/t1zNoM');
    		//Get the apparel t-shirt items
    		$apparelItems = $amazon->itemSearch(
    						array('SearchIndex' => 'Apparel',
    							'Keywords' => $artistName.'t-shirt',
    							'ResponseGroup' => 'Small, Images',
    							'AssociateTag' => 'actuatalk-20')); 
    		
    		//Get the music tracks
    		$cds = $amazon->itemSearch(array('SearchIndex' => 'Music',
								'Artist' => $artistName,
								'ResponseGroup' => 'Small, Images',
								'AssociateTag' => 'actuatalk-20'));

			//Get the posters
			$posters = $amazon->itemSearch(array('SearchIndex' => 'HomeGarden',
								'Keywords' => $artistName.'posters',
								'ResponseGroup' => 'Small, Images',
								'AssociateTag' => 'actuatalk-20'));	

			//Set the views
			$this->view->products = $apparelItems;
			$this->view->cds = $cds;
			$this->view->posters = $posters;			 
    	}
    	catch(Zend_Exception $e)
    	{
    		throw $e;
    	}
    }


}

