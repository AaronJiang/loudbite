<?php
//tests
class AccountController extends Zend_Controller_Action
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
     * Display the form for signing up
     *
     */
    public function newAction()
    {
        //Get the form
        $form = $this->getSignupForm();
    
        //add the form to the view
        $this->view->form = $form;
    }

    /**
     * Load the Login Form
     */
    public function loginAction()
    {
        //Initialize the form for the view
        $this->view->form = $this->getLoginForm();
    }
    
    /**
     * Authenticate login information
     */
    public function authenticateAction()
    {
        $form = $this->getLoginForm();
        
        if($form->isValid($_POST))
        {
            //Initialize the variables
            $email = $form->getValue("email");
            $password = $form->getValue("password");
            
            //Create a db object
            require_once "../application/models/Db/Db_Db.php";
            $db = Db_Db::conn();
            
           //Quote values
           $email = $db->quote($email);
           $password = $db->quote($password);
           
           //Check if the user is valid
           $statement = "SELECT count(id) AS total FROM accounts
                   WHERE email=".$email." AND password=".$password
                   ." AND status='active'";
           $result = $db->fetchOne($statement);
           
           //If we have at least one row then the users
           //email and password is valid
           if($result==1)
           {
               //Fetch the user's data
                $statement = "SELECT id, username, created_date FROM accounts
                     WHERE email = ".$email."
                     AND password = ".$password;
                $results = $db->fetchRow($statement);
                
                //Set the user's session
                $_SESSION['id'] = $results['id'];
                $_SESSION['username'] = $results['username'];
                $_SESSION['dateJoined'] = $results['created_date'];
                
                //Forward the user to the profile page
                $this->_forward("accountmanager");
               
           }else{
               //Set the error message the re-display the login page
               $this->view->message = "Username or password incorrect.";
               $this->view->form = $form;
               $this->render("login");
           }
        
        }else{
            $this->view->form = $form;
            $this->render("login");
        }    
    }
    
    /**
     * Account Manager
     */
    public function accountmanagerAction()
    {
        //Check if the user is logged in
        if(!isset($_SESSION['id']))
        {
            $this->_forward("login");
        }

        try
        {
            //Create a db object
            require_once "../application/models/Db/Db_Db.php";
            $db = Db_Db::conn();
            //Initialize data.
            $userId = $_SESSION['id'];
            $userName = $_SESSION['username'];
            $dateJoined = $_SESSION['dateJoined'];

            //Fetch all the users favorite artists.
            $statement = "SELECT b.artist_name, b.id,
                    aa.created_date as date_became_fan
                    FROM artists AS b
                    INNER JOIN accounts_artists aa ON aa.artist_id = b.id
                    WHERE aa.account_id = ?
                    AND aa.is_fav = 1";

            $favArtists = $db->fetchAll($statement, $userId);

            //Set the view variables
            $this->view->artists = $favArtists;
            $this->view->username = $userName;
            $this->view->dateJoined = $dateJoined;
        }
        catch(Zend_Db_Exception $e)
        {
            echo $e->getMessage();
        }

    }
    /**
     * Process the account form
     *
     */
    public function successAction()
    {
        $form = $this->getSignupForm();
    	if($form->isValid($_POST))
    	{
    		$email = $form->getValue('email');
    		$username = $form->getValue('username');
    		$password = $form->getValue('password');
    		
    		//Create Db Object
    		require_once "../application/models/Db/Db_Db.php";
    		$db = Db_Db::conn();
    		
    		//Create the record to save into the Db
    		$userData = array("username" => $username,
    		        "email" => $email,
    		        "password" => $password,
    		        "status" => "pending",
    		        "created_date" => new Zend_Db_Expr("NOW()")
    		        );
    		try
    		{
    	        //Insert into the account
    	        $db->insert('accounts',$userData);

    	        //Get the Id of he user
    	        $userId = $db->lastInsertId();
    	        
    	        //Send out thankyou email
    		}
    		catch(Zend_Db_Exception $e)
    		{
    		    $this->view->form = $form;
    		}
    	}
    	else
    	{
    	    $this->view->errors = $form->getMessages();
    	    $this->view->form = $form;
    	}
    }
    
    /**
     * Activate Account. Used once the user
     * receuves a welcome email and decides to authenticate
     * their account
     *
     */
    public function activateAction()
    {
        $emailToActive = $this->_request->getQuery('email');
        //check if the email exists
    }
    
    public function updateAction()
    {
        //Check if the user is logged in
    
        //Get the user's id
    
        //Get the user's information
    
        //Create the form
        $form = $this->getUpdateForm();
    
        //Check if the form has been submitted
        //if so validate and process
        if($_POST)
        {
            if($form->isValid($_POST))
            {
                //Get the values
                $username = $form->getValue('username');
                $password = $form->getValue('password');
                $email = $form->getValue('email');
                $aboutMe = $form->getValue('aboutme');
    
                //Save the file
                $form->getElement('avatar')->receive();
                echo 'update success';
            }
            else {
                $this->view->form = $form;
            }
        }
        else
        {
            $this->view->form = $form;
        }
    }
    
    /**
     * View All Accounts
     */
    public function viewAllAction()
    {
        //Create Db Object
        require_once "../application/models/Db/Db_Db.php";
        $db = Db_Db::conn();

        try 
        {
            //Create SQL statement to select data
            $statement = "SELECT id, username, created_date
                    From accounts WHERE status = 'active'";
            //Fetch the data
            $result = $db->fetchAll($statement);

            //Create the SQL statement to 
            //fetch the count of all active members
            $statement = "SELECT COUNT(id) as total_members
                    FROM accounts WHERE status='active'";
            //Fetch ONLY the count of active members
            $count = $db->fetchOne($statement);
            
            //Set the view variable
            $this->view->members = $result;
            $this->view->totalMembers = $count;
        }
        catch(Zend_Db_Exception $e)
        {
            echo $e->getMessage();
        }
    }
    
    /**
     * Create the sign up form
     */
    private function getSignupForm()
    {
        //Create Form
        $form = new Zend_Form();
        $form->setAction('success');
        $form->setMethod('post');
        $form->setAttrib('sitename','loudbite');

        //Add Element
        require_once "../application/models/Form/Elements.php";
        $LoudbiteElements = new Elements();

        //Create Username Field
        $form->addElement($LoudbiteElements->getUsernameTextField());

        //Create Email Field
        $form->addElement($LoudbiteElements->getEmailTextField());

        //Create Password Field
        $form->addElement($LoudbiteElements->getPasswordTextField());

        //Add Captcha
        $captchaElement = new Zend_Form_Element_Captcha(
                'signup',
                array('captcha'=>array(
                    'captcha'=>'Figlet',
                    'wordLen'=>6,
                    'timeout'=>600 ) ) 
                );
        $captchaElement->setLabel('Please type in the words 
            below to continue');

        $form->addElement($captchaElement);
        $form->addElement('submit','submit');
        $submitButton = $form->getElement('submit');
        $submitButton->setLabel('Create My Account!');

        return $form;
    }
    
    /**
     * Get Login Form
     */
    private function getLoginForm()
    {
        //Create the form
        $form = new Zend_Form();
        $form->setAction("authenticate");
        $form->setMethod("post");
        $form->setName("loginform");

        //Create text elements
        $emailElement = new Zend_Form_Element_Text("email");
        $emailElement->setLabel("Email:");
        $emailElement->setRequired(true);
        
        //Create Password element
        $passwordElement = new Zend_Form_Element_Password("password");
        $passwordElement->setLabel("Password:");
        $passwordElement->setRequired(true);
        
        //Create the submit button
        $submitButtonElement = new Zend_Form_Element_Submit("submit");
        $submitButtonElement->setLabel("Log in");
           
        //Add Elements to form
        $form->addElement($emailElement);
        $form->addElement($passwordElement);
        $form->addElement($submitButtonElement);
        
        return $form;
    }
    
    private function getUpdateForm()
    {
        //Create form
        $form = new Zend_Form();
        $form->setAction('update');
        $form->setMethod('post');
        $form->setAttrib('sitename', 'loudbite');
        $form->setAttrib('enctype', 'multipart/form-data');
        
        //Load elemet class
        require_once "../application/models/Form/Elements.php";
        $LoudbiteElements = new Elements();
        
        //Create Username Field
        $form->addElement($LoudbiteElements->getUsernameTextField());
        
        //Create Email Field.
        $form->addElement($LoudbiteElements->getEmailTextField());
        
        //Create Password Field.
        $form->addElement($LoudbiteElements->getPasswordTextField());
        
        //Create Text Area for About me.
        $textAreaElement = new Zend_Form_Element_Textarea('aboutme');
        $textAreaElement->setLabel('About Me:');
        $textAreaElement->setAttribs(array('cols' => 15,
                'rows' => 5));
        $form->addElement($textAreaElement);
        
        //Add File Upload
        $fileUploadElement = new Zend_Form_Element_File('avatar');
        $fileUploadElement->setLabel("Your Avatar:");
        $fileUploadElement->setDestination("../public/users");
        $fileUploadElement->addValidator('Count',false,1);
        $fileUploadElement->addValidator('Extension',false,'jpg,gif');
        $form->addElement($fileUploadElement);
        
        //Create a submit button.
        $form->addElement('submit', 'submit');
        $submitElement = $form->getElement('submit');
        $submitElement->setLabel('Update My Account');
        return $form;
    }

}









