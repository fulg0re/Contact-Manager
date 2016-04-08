<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/Contacts</title>
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
		<?php
			error_reporting(E_ALL);

			include_once("includes/functions.php");
			include_once("includes/config.php");

			if (isset($_GET['sortBy']) && isset($_GET['sortTurn']) && isset($_GET['activePage'])){
				$_POST['sortBy'] = $_GET['sortBy'];
				$_POST['sortTurn'] = $_GET['sortTurn'];
				$_POST['activePage'] = $_GET['activePage'];
			};
/*
			var_dump($_POST['activePage']);
			var_dump($_POST['sortTurn']);
			var_dump($_POST['sortBy']);
*/
			$contacts = getContacts();
		?>
		<div class='err'><h3><?php
								if (isset($_GET['msg'])){
									echo $_GET['msg'];
								};?></h3></div>
		<a href='logout.php'>logout</a>		
		<h3>MANAGEMENT MAIN PAGE</h3>
		<form action="controller.php" method="post">
			<input type="submit" name="addNewContact" value="ADD"></br>
			<table style="border: 1px solid">
				<tr>
					<th><a href="contacts.php?
						sortBy=lastname&
						activePage=<?php echo $_POST['activePage']?>&
						sortTurn=<?php turnSide($_POST['sortTurn']);?>">Last
							<?php
							if ($_POST['sortBy'] == "lastname"){
								inputImage();
							};
							?> </a></th>
					<th><a href="contacts.php?
						sortBy=firstname&
						activePage=<?php echo $_POST['activePage']?>&
						sortTurn=<?php turnSide($_POST['sortTurn']);?>">First
							<?php
							if ($_POST['sortBy'] == "firstname"){
								inputImage();
							};
							?> </a></th>
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

			<a href='contacts.php?
						sortBy=<?php echo $_POST['sortBy']?>&
						activePage=<?php
										$tempPage = (intval($_POST['activePage']));
										if ($tempPage > 1){
											echo (intval($_POST['activePage']) - 1);
										}else{
											echo 1;
										};
									?>&
						sortTurn=<?php echo $_POST['sortTurn']?>'>previous</a>

			<?php

			$maxPages = ceil($_POST['numberOfContacts']/MAX_ON_PAGE);
			$temp = 1;
			while ($temp <= $maxPages) {
				?>

				<a href='contacts.php?
						sortBy=<?php echo $_POST['sortBy']?>&
						activePage=<?php echo $temp?>&
						sortTurn=<?php echo $_POST['sortTurn']?>'><?php echo $temp?></a>

				<?php
				$temp++;
			};

			?>

			<a href='contacts.php?
						sortBy=<?php echo $_POST['sortBy']?>&
						activePage=<?php
										$tempPage = (intval($_POST['activePage']));
										if ($tempPage >= $maxPages){
											echo $maxPages;
										}else{
											echo (intval($_POST['activePage']) + 1);
										};
									?>&
						sortTurn=<?php echo $_POST['sortTurn']?>'>next</a>

		</form>
	</body>
</html>