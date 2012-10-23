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

    public function saveArtistAction()
    {
        //Initialize variables
        $artistName = $this->_request->getPost('artistName');
        $genre = $this->_request->getPost('genre');
        $rating = $this->_request->getPost('rating');
        $isFav = $this->_request->getPost('isFav');

        //Clean up inputs
        $artistName = $this->view->escape($artistName); 
        $genre = $this->view->escape($genre);
        $rating = $this->view->escape($rating);
        $isFav = $this->view->escape($isFav);
        
        //Save the input into DB
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









