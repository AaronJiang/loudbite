<?php

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
    		require "../application/models/Db/Db_Db.php";
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
        require "../application/models/Form/Elements.php";
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
    
    private function getUpdateForm()
    {
        //Create form
        $form = new Zend_Form();
        $form->setAction('update');
        $form->setMethod('post');
        $form->setAttrib('sitename', 'loudbite');
        $form->setAttrib('enctype', 'multipart/form-data');
        
        //Load elemet class
        require "../application/models/Form/Elements.php";
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









