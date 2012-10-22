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
    	if($this->_request->isPost())
    	{
    		$email = $this->_request->getPost('email');
    		$username = $this->_request->getPost('username');
    		$password = $this->_request->getPost('password');
    	}
    	else
    	{
    		throw new Exception("only post data accepted!");
    	}
    }

    /**
     * Display the form for signing up
     *
     */
    public function newAction()
    {
        //create Form
        $form = new Zend_Form();
        $form->setAction('success');
        $form->setMethod('post');
        $form->setDescription('sign up form');
        $form->setAttrib('sitename','loudbite');
        
        //Add elements
        
        //Create Username Field
        $form->addElement('text','username');
        $usernameElement = $form->getElement('username');
        $usernameElement->setLabel('Username:');
        
        //Create Email Field
        $form->addElement('text','email');
        $emailElement = $form->getElement('email');
        $emailElement->setLabel('Email:');
        
        //Create Password field
        $form->addElement('password','password');
        $passwordElement = $form->getElement('password');
        $passwordElement->setLabel('Password:');
        
        $form->addElement('submit', 'submit');
        $submitButton = $form->getElement('submit');
        $submitButton->setLabel('Create My Account!');
        
        //add the form to the view
        $this->view->form = $form;
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

        //Create the Zend_View object
       // $view = new Zend_View();
        //$view->setScriptPath("/var/zend/loudbite/application/view");
       // $view->render("update.phtml");

    }


}









