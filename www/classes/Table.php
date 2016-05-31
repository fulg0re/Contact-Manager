<?php

abstract class Table
{

	abstract public function getOneContact($contactId);
	abstract public function deleteRow($contactId);
	abstract public function processLogin($login, $password);

}
