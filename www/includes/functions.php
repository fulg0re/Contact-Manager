<?php

function GetConnection(){
    $conn = new mysqli("localhost", "root", "", "data");

    return $conn;
}

function DisplayErrorMassage($msg){
    echo "<div class='err'>$msg</div>";
}

function ProcessLogin($post){
    $conn = GetConnection();

    $query = "SELECT * FROM users WHERE username = '".$post['uname']."' and password = '".sha1($post['pass'])."' Limit 1";
    $results = $conn->query($query);
    if ($results->num_rows > 0){
        $row = $results->fetch_array(MYSQLI_ASSOC);
        $_SESSION['LoggedIn'] = true;
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        return true;
    }else {
        return false;
    }
}

function GetContacts(){
    $conn = GetConnection();
    $query = "SELECT * FROM contacts";

    $result = $conn->query($query);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}