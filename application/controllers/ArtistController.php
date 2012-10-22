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
        //Get all genres
        $genres = array("Electronic",
                "Country",
                "Rock",
                "R&B",
                "Hip-Hop",
                "Heavy-Metal",
                "Alternative Rock",
                "Christian",
                "Jazz",
                "Pop");
        //Set the view variables
        $this->view->genres=$genres;
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
}









