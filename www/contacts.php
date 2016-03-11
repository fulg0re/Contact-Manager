<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/Contacts</title>
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

				<?php
				foreach ($contacts as $v) {
					echo "<tr>";
						echo "<td>".$v['lastName']."</td>";
						echo "<td>".$v['firstName']."</td>";
						echo "<td>".$v['email']."</td>";
						echo "<td>".$v['cellPhone']."</td>";
						$contactId = $v['id'];
						echo "<td><a href='controller.php?editId=".$contactId."'>edit/view</a></td>";
						echo "<td><a href='controller.php?deleteId=".$contactId."'>delete</a></td>";
					echo "</tr>";
				}
				?>

			</table>
			<input type="submit" name="addNewContact" value="ADD"></br>
		</form>
	</body>
</html>