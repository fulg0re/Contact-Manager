<?php

abstract class Table
{

	abstract public function getOneContact($contactId);
	
	abstract public function deleteContact($contactId);
	
	abstract public function processLogin($login, $password);
	
	abstract public function addNewContact($contactId);
	
	abstract public function getAllContacts($contactId);
	
	abstract public function editContact($contactId);

}
