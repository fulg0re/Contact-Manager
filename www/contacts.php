<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/Contacts</title>
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
		<?php
			include_once("includes/functions.php");
			include_once("includes/config.php");
			if (!$_GET['activePage']){
				$activePage = 1;
			};
			$contacts = getContacts($_GET['activePage'], $_GET['sortBy'], $_GET['sortTurn'], $_GET['noSort']);
		?>		
		<div class='err'><h3><?php echo $_GET['msg'];?></h3></div>		
		<a href='logout.php'>logout</a>		
		<h3>MANAGEMENT MAIN PAGE</h3>
		<form action="controller.php" method="post">
			<input type="submit" name="addNewContact" value="ADD"></br>
			<table style="border: 1px solid">
				<tr>
					<th><a href="contacts.php?
							activePage=<?php echo $_GET['activePage']?>&
							sortBy=lastname&
							sortTurn=<?php echo $_POST['sortTurn']?>">Last
								<?php
									if ($_POST['sortBy'] == "lastname" && $_POST['sortTurn'] == "DESC"){
										echo "<img src='img/DESC.png' />";
									}else
									if ($_POST['sortBy'] == "lastname" && $_POST['sortTurn'] == "ASC"){
										echo "<img src='img/ASC.png' />";
									};
								?>
						</a></th>
					<th><a href="contacts.php?
							activePage=<?php echo $_GET['activePage']?>&
							sortBy=firstname&
							sortTurn=<?php echo $_POST['sortTurn']?>">First
								<?php
								if ($_POST['sortBy'] == "firstname" && $_POST['sortTurn'] == "DESC"){
									echo "<img src='img/DESC.png' />";
								}else
									if ($_POST['sortBy'] == "firstname" && $_POST['sortTurn'] == "ASC"){
										echo "<img src='img/ASC.png' />";
									};
								?>
						</a></th>
					<th>Email</th>
					<th>Best Phone</th>
				</tr>
				<?php foreach ($contacts as $v) {?>
					<tr>
						<td><?php echo $v['lastname']?></td>
						<td><?php echo $v['firstname']?></td>
						<td><?php echo $v['email']?></td>
						<td><?php switch ($v['best_phone']) {
									case "home_phone":
										echo $v['home_phone'];
										break;
									case "work_phone":
										echo $v['work_phone'];
										break;
									case "cell_phone":
										echo $v['cell_phone'];
										break;
								};?></td>
						<?php $contactId = $v['id'];?>
						<td><a href='edit.php?editId=<?php echo $contactId?>'>edit/view</a></td>
						<td><a href='controller.php?deleteId=<?php echo $contactId?>'>delete</a></td>
					</tr>
				<?php }?>				
			</table>
			<input type="submit" name="addNewContact" value="ADD"></br></br>

			<?php

			$maxPages = ceil($_POST['numberOfContacts']/MAX_ON_PAGE);
			$temp = 1;
			while ($temp <= $maxPages) {
				$tempUrl = "controller.php?activePage=".$temp;
				?>

				<a href='contacts.php?
						activePage=<?php echo $temp?>&
						sortBy=<?php echo $_POST['sortBy']?>&
						sortTurn=<?php echo $_POST['sortTurn']?>&
						noSort=false'><?php echo $temp?></a>

				<?php
				$temp++;
			};

			?>

		</form>
	</body>
</html>