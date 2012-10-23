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
        //Create Username Field
        $form->addElement('text','username');
        $usernameElement = $form->getElement('username');
        $usernameElement->setLabel('Username:');
        $usernameElement->setOrder(1)->setRequired(true);

        //Add validator
        $usernameElement->addValidator(
                        new Zend_Validate_StringLength(6,20)
                        );
        //Add Filter
        $usernameElement->addFilter(new Zend_Filter_StringToLower());
        $usernameElement->addFilter(new Zend_Filter_StripTags());
        
        //Create Email Field
        $form->addElement('text','email');
        $emailElement = $form->getElement('email');
        $emailElement->setLabel('Email:');
        $emailElement->setOrder(3)->setRequired(true);
        
        //Add Validator
        $emailElement->addValidator(new Zend_Validate_EmailAddress());
        //Add Filter
        $emailElement->addFilter(new Zend_Filter_StripTags());
        
        //Create Password Field.
        $form->addElement('password', 'password');
        $passwordElement = $form->getElement('password');
        $passwordElement->setLabel('Password:');
        $passwordElement->setOrder(2)->setRequired(true);
        
        //Add Validator
        $passwordElement->addValidator(new Zend_Validate_StringLength(6,20));
        //Add Filter
        $passwordElement->addFilter(new Zend_Filter_StripTags());
        
        $form->addElement('submit', 'submit');
        $submitButton = $form->getElement('submit');
        $submitButton->setLabel('Create My Account!');
        $submitButton->setOrder(4);
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









