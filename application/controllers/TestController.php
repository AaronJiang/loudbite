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

    /**
     * Youtube webservices example
     * using getVideoEnty()
     */
	public function testYoutubeAction()
	{
		Zend_Loader::loadClass("Zend_Gdata_YouTube");
		
		try 
		{
			$YouTube = new Zend_Gdata_YouTube();

			//Get the specific video
			$video = $YouTube->getVideoEntry("NwrL9MV6jSk");
			$this->view->video = $video;
		} 
		catch (Zend_Service_Exception $e) 
		{
			throw $e;
		}
	}
	
	/**
	 * Youtube keyword search example
	 * 
	 */
	public function testYoutubeKeywordAction()
	{
		try 
		{
			$YouTube = new Zend_Gdata_YouTube();
			
			//Create a new query
			$query = $YouTube->newVideoQuery();
			
			//Set the properties
			$query->videoQuery = 'Marvin Gaye';
			$query->maxResults = 5;
			
			//Get a video from a category
			$videos = $YouTube->getVideoFeed($query);
			
			$this->view->videos = $videos;
		}
		catch(Zend_Service_Exception $e)
		{
			throw $e;
		}
	}
	
	/**
	 * Testing our flick connection and retreiving images
	 * 
	 */
    public function testFlickrConnAction()
    {
    	try 
    	{
    		$flickr = new Zend_Service_Flickr('01a20f07abe1967002c3ec4967c46034');
    		
    		//Get the photos by the user. Find the user by the email.
    		$photos = $flickr->userSearch('aaron.jijesoft@gmail.com');
    		$this->view->photos = $photos;
    	}
    	catch(Zend_Service_Exception $e)
    	{
    		throw $e;
    	}
    }
    
    /**
     * Teast flickr tag based searching
     * 
     */
    public function testFlickrTagsAction()
    {
    	try 
    	{
    		$flickr = new Zend_Service_Flickr('01a20f07abe1967002c3ec4967c46034');
    		$options = array('per_page' => 5);
    		$photos = $flickr->tagSearch('php',$options);	
    		
    		$this->view->photos = $photos;
    	}
    	catch(Zend_Service_Exception $e)
    	{
    		throw $e;
    	}
    }
    
}

