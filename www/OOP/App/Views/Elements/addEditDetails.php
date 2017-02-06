<div class="edit-form">
    <form id="form2" action="<?php echo $formAction ?>" method="post">
        <div id="field">
            <p id="edit-title">Information</p>
            <label for="firstname">FirstName*</label>
                <input class="input" 
                    type="text" 
                    name="firstname" 
                    maxlength="15"
                    value="<?php	echo (isset($firstname)) ? $firstname : null;?>" /><br>
            <label for="lastname">LastName*</label>
                <input class="input" 
                    type="text" 
                    name="lastname" 
                    maxlength="15"
                    value="<?php echo (isset($lastname)) ? $lastname : null;?>" /><br>
            <label for="email">Email*</label>
                <input class="input" 
                    type="text" 
                    name="email"
                    value="<?php echo (isset($email)) ? $email : null;?>" /><br>
            <label for="home_phone">HomePhone*</label>
                <input class="input-radio" 
                    type="radio" 
                    name="best_phone" 
                    value="home_phone" 
                    checked>
                <input class="input" 
                    type="text" 
                    name="home_phone"
                    value="<?php echo (isset($home_phone)) ? $home_phone : null;?>" /><br>
            <label for="work_phone">WorkPhone*</label>
                <input class="input-radio" 
                    type="radio" 
                    name="best_phone" 
                    value="work_phone"
                    <?php echo (isset($best_phone) && $best_phone == "work_phone") ? "checked" : null;?>>
                <input class="input" 
                    type="text" 
                    name="work_phone"
                    value="<?php echo (isset($work_phone)) ? $work_phone : null;?>" /><br>
            <label for="cell_phone">CellPhone*</label>
                <input class="input-radio" 
                    type="radio" 
                    name="best_phone" 
                    value="cell_phone"
                    <?php echo (isset($best_phone) && $best_phone == "cell_phone") ? "checked" : null;?>>
                <input class="input" 
                    type="text" 
                    name="cell_phone"
                    value="<?php echo (isset($cell_phone)) ? $cell_phone : null;?>" /><br>
            <label for="adress1">Adress 1</label>
                <input class="input" 
                    type="text" 
                    name="adress1"
                    value="<?php echo (isset($adress1)) ? $adress1 : null;?>" /><br>
            <label for="adress2">Adress 2</label>
                <input class="input" 
                    type="text" 
                    name="adress2"
                    value="<?php echo (isset($adress2)) ? $adress2 : null;?>" /><br>
            <label for="city">City</label>
                <input class="input" 
                    type="text" 
                    name="city"
                    value="<?php echo (isset($city)) ? $city : null;?>" /><br>
            <label for="state">State</label>
                <input class="input" 
                    type="text" 
                    name="state"
                    value="<?php echo (isset($state)) ? $state : null;?>" /><br>
            <label for="zip">Zip</label>
                <input class="input" 
                    type="text" 
                    name="zip"
                    value="<?php echo (isset($zip)) ? $zip : null;?>" /><br>
            <label for="country">Country</label>
                <input class="input" 
                    type="text" 
                    name="country"
                    value="<?php echo (isset($country)) ? $country : null;?>" /><br>
            <label for="birthday">Birthday*</label>
                <input class="input" 
                    type="text" 
                    name="birthday"
                    placeholder="YYYY-MM-DD"
                    value="<?php echo (isset($birthday)) ? $birthday : null;?>" /><br>
            <input type="hidden" name="id" value="<?php echo (isset($id)) ? $id : null;?>"><br>
        </div>

        <div onClick="document.forms['form2'].submit();" id="button-submit">

            <div id="add-button-img"></div>
            <p id="add-button-p"><?php echo getButtonName() ?></p>
        </div> 
        <input type="hidden" 
            name="<?php echo getButtonName() ?>Button" 
            value="<?php echo getButtonName() ?>"><br>
    </form>
</div>