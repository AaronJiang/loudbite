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
    
    public function amazonTestAction()
    {
    	try 
    	{
    		$amazon = new Zend_Service_Amazon('AKIAJI6PH75BYC7SO7JA','US',
    							'fARC6sT+cgQHF+H84NNGH/tNLiXwtB0hU/t1zNoM');
    		$results = $amazon->itemSearch(array('SearchIndex' => 'Books',
    							'Keywords' => 'PHP',
                                'Condition' => 'Used',
    							'Publisher' => 'Apress',
    							'Sort' => 'titlerank',
    							'ItemPage' => '3',
    							'ResponseGroup' => 
    								'Small,Similarities,
    								Reviews, EditorialReview',
    							'AssociateTag' => 'actuatalk-20'));
    		foreach($results as $result)
    		{
    			echo "<b>".$result->Title."</b><br>";
    			
    			//Fetch the customer reviews and display the content
    			$customerReviews = $result->CustomerReviews;
    			
    			if(empty($customerReviews))
    			{
    				echo "No customer reviews.<br>";
    			}
    			else
    			{
    				foreach($customerReviews as $customerReview)
    				{
    					echo "Review Summary:".$customerReview->Summary."...<br>";
    				}	
    			}

    			$similarProduct = $result->SimilarProducts;
    			
    			if(empty($similarProduct))
    			{
    				echo "No recommendations.";
    			}	
    			else
    			{
    				foreach($similarProduct as $similar)
    				{
    					echo "Recommended Books: ".$similar->Title."<br>";
    				}	
    			}	
    			echo "<br><br>";
    		}

    	}
    	catch(Zend_Exception $e)
    	{
    		throw $e;
    	}
    	
    	echo "<br>";
		echo "Total Books: ".$results->totalResults();
		echo "<br>";
		echo "Total Pages: ".$results->totalPages();
		$this->_helper->viewRenderer->setNoRender();
    	
    	$this->_helper->viewRenderer->setNoRender();
    }
    
    public function rssTestAction()
    {
    	//Load the RSS document
    	try 
    	{
			$rssFeedAsFile = 'rssexample.html';
			$feed = Zend_Feed::importFile($rssFeedAsFile);

			//Parse and store the RSS data
			$this->view->title = $feed->title();
			$this->view->link = $feed->link();
			$this->view->description = $feed->description();
			$this->view->ttl = $feed->ttl();
			$this->view->copyright = $feed->copyright();
			$this->view->language = $feed->language();
			$this->view->category = $feed->category();
			$this->view->pubDate = $feed->pubDate();
			
			//Get the articles
			$articles = array();
			foreach($feed as $article)
			{
				$articles[] = array(
					"title" => $article->title(),
					"description" => $article->description(),
					"link" => $article->link(),
					"author" => $article->author(),
					"enclosure" =>
					 array("url" => $article->enclosure['url'],
					 	   "type" => $article->enclosure['type']	
								)	
							);
			}	
			
			$this->view->articles = $articles;
    	}
    	catch(Zend_Feed_Exception $e)
    	{
    		throw $e;
    	}
    }
    
}

