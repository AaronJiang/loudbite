<?php

class ArtistController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function listAllArtistsAction()
    {
        // action body
    }

    public function affiliatecontentAction()
    {
        // action body
    }

    public function newAction()
    {
        //Check if the user is logged in
        //Set the view varibales
        $this->view->form = $this->getAddArtistForm();
    }
    
    /**
     * Save Artist to Db
     */
    public function saveArtistAction()
    {
        
        //Create instance of artist form
        $form = $this->getAddArtistForm();
        
        //Check for logged in status
        if(!isset($_SESSION['id']))
        {
            $this->_forward("login","account");
        }
        
        //Check if there were no errors
        if($form->isValid($_POST))
        {
            //Initialize the variables
            $artistName = $form->getValue('artistName');
            $genre = $form->getValue('genre');
            $rating = $form->getValue('rating');
            $isFav = $form->getValue('isFavorite');

            $userId = $_SESSION['id'];
    
            //Create a db object
            require_once "../application/models/Db/Db_Db.php";
            $db = Db_Db::conn();
            
            $db->beginTransaction();
            
            try
            {
                //Initialize data to save into DB
                $artistData = array("artist_name" => $artistName,
                            "genre" => $genre,
                            "created_date" => new Zend_Db_Expr("NOW()")
                        );
                
                //Insert the artist into the Db
                $db->insert('artists',$artistData);
                
                //Fetch the artist id
                $artistId = $db->lastInsertId();
                
                //Initialize data for the account artists table
                $accountArtistData = array("account_id" => $userId,
                            "artist_id" => $artistId,
                            "rating"    => $rating,
                            "is_fav"    => $isFav,
                            "created_date" =>
                            new Zend_Db_Expr("NOW()")
                        );
                //Insert the data.
                $db->insert('accounts_artists', $accountArtistData);
                $db->commit();
                
            }
            catch(Zend_Db_Exception $e)
            {
                //If there were errors roll everything back
                $db->rollBack();
                echo $e->getMessage();
            }
        }
        else
        {
          $this->view->errors = $form->getMessages();
          $this->view->form = $form;
        }
    }

    /**
    * Display news for users artist.
    */
    public function newsAction()
    {
        //Check if the user is logged in
        //Get the user's Id
        //Get the artists. (Example uses static artists)
        $artists = array("Thievery Corporation",
        "The Eagles",
        "Elton John");
        //Set the view variables
        $this->view->artists = $artists;
        //Find the view in our new location
        $this->view->setScriptPath("/var/zend/loudbite/");
        $this->render("news");
    }
    
    /**
     * Remove favorite artist
     */
    public function removeAction()
    {
        //Check if the user is loggedin 

        //Get the user's id

       //Get the user's artist with rating.
        $artists = array(
                 array( "name" => "Thievery Corporation", "rating" => 5),
                 array("name" => "The Eagles", "rating" => 5),
                 array("name" => "Elton John", "rating" => 4)
        );

        //Set the view variables
        $this->view->totalArtist = count($artists);
        $this->view->artists = $artists;
    }
    
    /**
     * Display all the artists in the system
     */
    public function listAction()
    {
    	$currentPage = 1;
    	//Check if the user is not on page 1
    	$i = $this->_request->getQuery('i');
    	if(!empty($i))
    	{
    		$currentPage = $this->_request->getQuery('i');
    	}
    	
    	//Create a db object
    	require_once "../application/models/Db/Db_Db.php";
    	$db = Db_Db::conn();
    	
    	//Create a Zend_db_select object
    	$sql = new Zend_Db_Select($db);
    	
    	//Define the columns to retrieve as well as table.
    	$columns = array("id","artist_name");
    	$table = array("artists");
    	
    	//SELECT `artists`.`id`, `artists`.`artist_name` FROM `artists`
		$statement = $sql->from($table, $columns);
    	
     	//Initialize the Zend_Paginator
     	$paginator = Zend_Paginator::factory($statement);
    	
     	//Set the properties for the pagination
     	$paginator->setItemCountPerPage(4);
     	$paginator->setPageRange(3);
     	$paginator->setCurrentPageNumber($currentPage);
    	
     	$this->view->paginator = $paginator;
    	
    }
    
    /**
     * Create Add Artist Form
     * 
     * @return Zend_From
     */
    private function getAddArtistForm()
    {
        $form = new Zend_Form();
        $form->setAction("save-artist");
        $form->setMethod("post");
        $form->setName("addartist");
        
        //Create artist name text field
        $artistNameElement = new Zend_Form_Element_Text('artistName');
        $artistNameElement->setLabel("Artist Name:");
        
        //Create genres select menu
        $genres = array("multiOptions" => array
        (
            "electronic"     => "Electronic",
            "country"         => "Country",
            "rock"           => "Rock",
            "r_n_b"          => "R & B",
            "hip_hop"        => "Hip-Hop",
            "heavy_metal" => "Heavy-Metal",
            "alternative_rock" => "Alternative Rock",
            "christian"        => "Christian",
            "jazz"            => "Jazz",
            "pop"             => "Pop"
          ));
        
        $genreElement = new Zend_Form_Element_Select('genre',$genres);
        $genreElement->setLabel("Genres:")->setRequired(true);
        
        //Create favorite radio buttons.
        $favoriteOptions = array("multiOptions" => array
        (
            "1" => "yes",
            "0" => "no"
        ));
        
        $isFavoriteListElement = new Zend_Form_Element_Radio('isFavorite',
                                 $favoriteOptions);
        $isFavoriteListElement->setLabel("Add to Favorite List:");
        $isFavoriteListElement->setRequired(true);
        
        //Create Rating raio button
        $ratingOptions = array("multiOptions" => array
                (
                        "1" => "1",
                        "2" => "2",
                        "3" => "3",
                        "4" => "4",
                        "5" => "5"
                ));
        
        $ratingElement = new Zend_Form_Element_Radio('rating',$ratingOptions);
        $ratingElement->setLabel("Rating:");
        $ratingElement->setRequired(true)->addValidator(new Zend_Validate_Alnum(false));
        
        //Create submit button
        $submitButton = new Zend_Form_Element_Submit("submit");
        $submitButton->setLabel("Add Artist");
        
        //Add Element to form
        $form->addElement($artistNameElement);
        $form->addElement($genreElement);
        $form->addElement($isFavoriteListElement);
        $form->addElement($ratingElement);
        $form->addElement($submitButton);
        
        return $form;
        
    }
    
}









