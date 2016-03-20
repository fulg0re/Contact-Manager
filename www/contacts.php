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
		
		<div class='err'><h3><?php echo $_GET['msg'];?></h3></div>
		
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

				<?php foreach ($contacts as $v) {?>
					<tr>
						<td><?php echo $v['lastName']?></td>
						<td><?php echo $v['firstName']?></td>
						<td><?php echo $v['email']?></td>
						<td><?php if ($v['homePhoneChecked'] == "true") {
									echo $v['homePhone'];
								}else if ($v['workPhoneChecked'] == "true"){
									echo $v['workPhone'];
								}else{
									echo $v['cellPhone'];
								}?></td>
						<?php $contactId = $v['id'];?>
						<td><a href='controller.php?editId=<?php echo $contactId?>'>edit/view</a></td>
						<td><a href='controller.php?deleteId=<?php echo $contactId?>'>delete</a></td>
					</tr>
				<?php }?>
				
			</table>
			<input type="submit" name="addNewContact" value="ADD"></br>
		</form>
	</body>
</html>