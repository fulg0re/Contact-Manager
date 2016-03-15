<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/Contacts</title>
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
		<?php
			include_once("includes/functions.php");
			$contacts = getContacts();
		?>
		
		<div class='err'><h3><?echo $_GET['msg'];?></h3></div>
		
		<a href='logout.php'>logout</a>
		
		<h3>MANAGEMENT MAIN PAGE</h3>
		<form action="controller.php" method="post">
			<input type="submit" name="addNewContact" value="ADD"></br>
			<table style="border: 1px solid">

				<tr>
					<th><a href="#">Last</a></th>
					<th><a href="#">First</a></th>
					<th>Email</th>
					<th>Best Phone</th>
				</tr>

				<?foreach ($contacts as $v) {?>
					<tr>
						<td><?echo $v['lastName']?></td>
						<td><?echo $v['firstName']?></td>
						<td><?echo $v['email']?></td>
						<td><?	if ($v['homePhoneChecked'] == "YES") {
									echo $v['homePhone'];
								}else if ($v['workPhoneChecked'] != "YES"){
									echo $v['workPhone'];
								}else{
									echo $v['cellPhone'];
								}?></td>
						<?$contactId = $v['id'];?>
						<td><a href='controller.php?editId=<?echo $contactId?>'>edit/view</a></td>
						<td><a href='controller.php?deleteId=<?echo $contactId?>'>delete</a></td>
					</tr>
				<?}?>
				
			</table>
			<input type="submit" name="addNewContact" value="ADD"></br>
		</form>
	</body>
</html>