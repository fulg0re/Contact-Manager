<?php

function displayLoginForm(){
    ?>

    <h3>Login</h3>
    <form action="" method="post">
        <label for="uname">UserName</label>
            <input type="text" name="uname" id="uname" value="" /></br>
        <label for="pass">Password</label>
            <input type="password" name="pass" id="pass" value="" /></br>

        <input type="submit" name="submitted" value="Login" /></br>
    </form>

    <?php
}

function displayContactForm(){

    $contacts = getContacts();
    ?>

    <h3>MANAGEMENT MAIN PAGE</h3>
    <form action="" method="post">
        <input type="submit" name="buttonAdd" value="ADD"></br>
        <table style="border: 1px solid">

            <tr>
                <th><a href="#">Last</a></th>
                <th><a href="#">First</a></th>
                <th>Email</th>
                <th>Best Phone</th>
            </tr>

            <?php
            foreach ($contacts as $v) {
                echo "<tr>";
                    echo "<td>".$v['LastName']."</td>";
                    echo "<td>".$v['FirstName']."</td>";
                    echo "<td>".$v['Email']."</td>";
                    echo "<td>".$v['BestPhone']."</td>";
                    echo "<td><a href='#'>edit/view</a></td>";
                    echo "<td><a href='#'>delete</a></td>";
                echo "</tr>";
            }
            ?>

        </table>
        <input type="submit" name="buttonAdd" value="ADD"></br>
    </form>

    <?php

}

function displayAddForm(){
    ?>

    <h3>Contact Details</h3>
    <form action="" method="post">
        <label for="first">First</label>
            <input type="text" name="first" id="first" value="" /></br>
        <label for="last">Last</label>
            <input type="text" name="last" id="last" value="" /></br>
        <label for="email">Email</label>
            <input type="text" name="email" id="email" value="" /></br>
        <label for="home">Home</label>
            <input type="radio" name="homeRadioB" value="">
            <input type="text" name="home" id="home" value="" /></br>
        <label for="work">Work</label>
            <input type="radio" name="workRadioB" value="">
            <input type="text" name="work" id="work" value="" /></br>
        <label for="cell">Cell</label>
            <input type="radio" name="cellRadioB" value="">
            <input type="text" name="cell" id="cell" value="" /></br>
        <label for="adress1">Adress 1</label>
            <input type="text" name="adress1" id="adress1" value="" /></br>
        <label for="adress2">Adress 2</label>
            <input type="text" name="adress2" id="adress2" value="" /></br>
        <label for="city">City</label>
            <input type="text" name="city" id="city" value="" /></br>
        <label for="state">State</label>
            <input type="text" name="state" id="state" value="" /></br>
        <label for="zip">Zip</label>
            <input type="text" name="zip" id="zip" value="" /></br>
        <label for="country">Country</label>
            <input type="text" name="country" id="country" value="" /></br>
        <label for="birthday">Birthday</label>
            <input type="text" name="birthday" id="birthday" value="" /></br>

        <input type="submit" name="submitted" value="Done" /></br>
    </form>

    <?php
}