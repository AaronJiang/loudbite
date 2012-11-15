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
     * Create index
     * 
     */
    public function createIndexAction()
    {
    	try 
    	{
    		//Create an index
    		$Index = Zend_Search_Lucene::create("../application/searchindex");
			
    		//Create a document
    		$Artist1 = new Zend_Search_Lucene_Document();
    		$Artist2 = new Zend_Search_Lucene_Document();
    		$Artist3 = new Zend_Search_Lucene_Document();
    		$Artist4 = new Zend_Search_Lucene_Document();
    		$Artist5 = new Zend_Search_Lucene_Document();
    		
    		//Add the artist data
			$Artist1->addField(Zend_Search_Lucene_Field::
			      Text('artist_name', 'Paul Oakenfold', 'utf-8'));
			$Artist1->addField(Zend_Search_Lucene_Field::
			      Keyword ('genre', 'electronic'));
			$Artist1->addField(Zend_Search_Lucene_Field::
			      UnIndexed ('date_formed', '1990'));
			$Artist1->addField(Zend_Search_Lucene_Field::
			      Text('description', 'Paul Oakenfold description
			         will go here.'));
			$Artist1->addField(Zend_Search_Lucene_Field::
			      UnIndexed ('artist_id', '1'));
			$Artist1->addField(Zend_Search_Lucene_Field::
			      UnStored('full_profile', "Paul Oakenfold's
			            Full Profile will go here."));
    		
			$Artist2->addField(Zend_Search_Lucene_Field::
					Text('artist_name', 'Christopher Lawrence', 'utf-8'));
			$Artist2->addField(Zend_Search_Lucene_Field::
					Keyword ('genre', 'electronic'));
			$Artist2->addField(Zend_Search_Lucene_Field::
					UnIndexed ('date_formed', '1991'));
			$Artist2->addField(Zend_Search_Lucene_Field::
					Text('description', 'Christopher Lawrence description
         				will go here.'));
			$Artist2->addField(Zend_Search_Lucene_Field::
					UnIndexed ('artist_id', '2'));
			$Artist2->addField(Zend_Search_Lucene_Field::
					UnStored('full_profile', "Christopher Lawrence's
						Full Profile will go here."));	

			$Artist3->addField(Zend_Search_Lucene_Field::
					Text('artist_name', 'Sting', 'utf-8'));
			$Artist3->addField(Zend_Search_Lucene_Field::
					Keyword ('genre', 'rock'));
			$Artist3->addField(Zend_Search_Lucene_Field::
					UnIndexed ('date_formed', '1982'));
			$Artist3->addField(Zend_Search_Lucene_Field::
					Text('description', 'Sting description
        				 will go here.'));
			$Artist3->addField(Zend_Search_Lucene_Field::
					UnIndexed ('artist_id', '3'));
			$Artist3->addField(Zend_Search_Lucene_Field::
					UnStored('full_profile', "Sting's Full Profile
          				 will go here."));
				
			$Artist4->addField(Zend_Search_Lucene_Field::
					Text('artist_name', 'Elton John', 'utf-8'));
			$Artist4->addField(Zend_Search_Lucene_Field::
					Keyword ('genre', 'rock'));
			$Artist4->addField(Zend_Search_Lucene_Field::
					UnIndexed ('date_formed', '1970'));
			$Artist4->addField(Zend_Search_Lucene_Field::
					Text('description', 'Elton John description
        				 will go here.'));
			$Artist4->addField(Zend_Search_Lucene_Field::
					UnIndexed ('artist_id', '4'));
			$Artist4->addField(Zend_Search_Lucene_Field::
					UnStored('full_profile', "Elton John's Full Profile
           				 will go here."));
			
			$Artist5->addField(Zend_Search_Lucene_Field::
					Text('artist_name', 'Black Star', 'utf-8'));
			$Artist5->addField(Zend_Search_Lucene_Field::
					Keyword ('genre', 'hip hop'));
			$Artist5->addField(Zend_Search_Lucene_Field::
					UnIndexed ('date_formed', '1999'));
			$Artist5->addField(Zend_Search_Lucene_Field::
					Text('description', 'Black Star description
        				 will go here.'));
			$Artist5->addField(Zend_Search_Lucene_Field::
					UnIndexed ('artist_id', '3'));
			$Artist5->addField(Zend_Search_Lucene_Field::
					UnStored('full_profile', "Black Star's Full Profile
          				 will go here."));
				
    		//Add the documents to the index
    		$Index->addDocument($Artist1);
    		$Index->addDocument($Artist2);
    		$Index->addDocument($Artist3);
    		$Index->addDocument($Artist4);
    		$Index->addDocument($Artist5);
    		
    		echo 'Index created<br/>';
    		echo "total documents: ".$Index->maxDoc();
    	}
    	catch(Zend_Search_Exception $e)
    	{
    		echo $e->getMessage();
    	}
    	
    	//Supress the view
    	$this->_helper->viewRenderer->setNoRender();
    }
    
    /**
     * Update our index
     *
     */
    public function updateIndexAction()
    {
    	try
    	{
    		//Update an index
    		$Index = Zend_Search_Lucene::open("../application/searchindex");
    	}
    	catch(Zend_Search_Exception $e)
    	{
    		echo $e->getMessage();
    	}
    	 
    	echo "index opened for reading/updating";
    	$this->_helper->viewRenderer->setNoRender();
    }
    
    /**
     * Delete the documents
     * 
     */
    public function deleteDocumentAction()
    {
    	try
    	{
    		//Open the index for reading
    		$Index = Zend_Search_Lucene::open("../application/searchindex");
    		
    		//Create the term to delete the documents
    		$hits = $Index->find("genre:electronic");
    		
    		foreach($hits as $hit)
    		{
    			$Index->delete($hit->id);
    		}
    		
    		$Index->commit();
    	}
    	catch(Zend_Search_Exception $e)
    	{
    		echo $e->getMessage();
    	}
    	
    	echo "Deletion completed<br>";
    	echo "Total documents: ".$Index->numDocs();
    	
    	//Suppress the view
    	$this->_helper->viewRenderer->setNoRender();
    }

}

