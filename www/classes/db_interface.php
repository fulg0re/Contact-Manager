<?php

interface dbInterface{

	public function __construct($dbHost, $dbUser, $dbPassword, $dbName);

	public function connect();
	
	public function disconnect();
	
	public function query($query, $method);
	
	public function getNumRows();
	
	public function getLastInsertId();
	
	public function getArray();
	
	public function getLastQuery();
}
