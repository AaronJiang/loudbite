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

    public function parseHtmlAction()
    {
    	try 
    	{
    		//Open the index for updating
    		$Index = Zend_Search_Lucene::open('../application/searchindex');

    		//Set path to the html parse
    		$htmlDocPath = 'terms.html';
    		
    		//Check if the file is present
    		if(!file_exists($htmlDocPath))
    		{
    			throw new Exception("Could not find file $htmlDocPath.");
    		}	
    		
    		//Parse the html file
    		$htmlDoc = Zend_Search_Lucene_Document_Html::loadHTMLFile($htmlDocPath);
    		
    		//Example of getters and property calls
    		$links = $htmlDoc->getLinks();
    		$headerLinks = $htmlDoc->getHeaderLinks();
    		$title = $htmlDoc->title;
    		$body = $htmlDoc->body;
    		
    		//Add the content to the index
    		$Index->addDocument($htmlDoc);
    		
    		echo 'Successfully parsed HTML file.<br/>';
			echo 'Total Documents:'. $Index->numDocs().'<br/><br/>';
			//Validate parsed links within document
			echo "Links Parsed<br/>";
			foreach($links as $link){
				echo "$link <br/>";
			}
    	}
    	catch(Zend_Search_Exception $e)
    	{
    		echo $e->getMessage();
    	}
    	
    	//Suppress the view
    	$this->_helper->viewRenderer->setNoRender();
    }
    
    /**
     * Result, fetch the result and display to the user
     * 
     */
    public function resultAction()
    {
    	//Open the index to search in
    	$Index = Zend_Search_Lucene::open('../application/searchindex');
    	
    	//Set the properties for the index
    	$Index->setDefaultSearchField('artist_name');
    	$Index->setResultSetLimit(10);
    	
    	//Construct query
    	$query = 'genre:electronic';
		$query = Zend_Search_Lucene_Search_QueryParser::parse($query);
    	
		//Search
		$hits = $Index->find($query,'artist_name', SORT_STRING, SORT_ASC);

		$text = "";
		foreach($hits as $hit)
		{
			$text .= "<tr><td>
			<a href='artist/'>$hit->artist_name</a>
			$hit->genre
			</td></tr>";
			$text .= "<tr><td>$hit->description<br/><br/></td></tr>";
		}
		
		//Highlight the words.
		$text = $query->htmlFragmentHighlightMatches($text);
		
		//Set the view variables
		$this->view->text = $text;
    }
}

