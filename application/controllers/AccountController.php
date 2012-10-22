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
    		throw new Exception("only post data accepted!");
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

        //Create Email Field
        $form->addElement('text','email');
        $emailElement = $form->getElement('email');
        $emailElement->setLabel('Email:');
        $emailElement->setOrder(3)->setRequired(true);

        //Create Password Field.
        $form->addElement('password', 'password');
        $passwordElement = $form->getElement('password');
        $passwordElement->setLabel('Password:');
        $passwordElement->setOrder(2)->setRequired(true);
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

        //Create the Zend_View object
       // $view = new Zend_View();
        //$view->setScriptPath("/var/zend/loudbite/application/view");
       // $view->render("update.phtml");

    }


}









