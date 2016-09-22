<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/Contacts</title>
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
        <!-- error part -->
		<div class='err'><h3><?php echo (isset($_POST['msg'])) ? $_POST['msg'] : null;?></h3></div>
		<a href='logout'>logout</a>
		<h3>MANAGEMENT MAIN PAGE</h3>
		<form action="controller.php" method="post">
			<a href='selection.php'>selectionPage</a><br><br>
			<input type="submit" name="addNewContact" value="ADD"></br>
			<?php if (!isset($_POST['noContacts'])): ?>
				<table style="border: 1px solid">
					<tr>
						<th><a href="contacts.php?
							sortBy=lastname&
							activePage=<?php echo $_POST['activePage']?>&
							sortTurn=<?php echo (turnSide($_POST['sortTurn']));?>">Last
								<img src='<?php echo ($_POST['sortBy'] == "lastname") ? inputImage() : null;?>' /></a></th>
						<th><a href="contacts.php?
							sortBy=firstname&
							activePage=<?php echo $_POST['activePage']?>&
							sortTurn=<?php echo (turnSide($_POST['sortTurn']));?>">First
								<img src='<?php echo ($_POST['sortBy'] == "firstname") ? inputImage() : null;?>' /></a></th>
						<th>Email</th>
						<th>Best Phone</th>
					</tr>
					<?php foreach ($contacts as $v): ?>
						<tr>
							<td><?php echo $v['lastname']?></td>
							<td><?php echo $v['firstname']?></td>
							<td><?php echo $v['email']?></td>
							<td><?php switch ($v['best_phone']):
									case "home_phone":
										echo $v['home_phone'];
										break;
									case "work_phone":
										echo $v['work_phone'];
										break;
									case "cell_phone":
										echo $v['cell_phone'];
										break;
								endswitch; ?></td>
							<?php $contactId = $v['id'];?>
							<td><a href='controller.php?editId=<?php echo $contactId?>'>edit/view</a></td>
							<td><a href='controller.php?deleteId=<?php echo $contactId?>'>delete</a></td>
						</tr>
					<?php endforeach; ?>
				</table>
			<?php else: ?>
				<h2><?php echo $_POST['noContacts'] ?></h2>
			<?php endif; ?>
			<input type="submit" name="addNewContact" value="ADD"></br></br>

			<a href='contacts.php?
						sortBy=<?php echo $_POST['sortBy']?>&
						activePage=<?php $tempPage = (intval($_POST['activePage']));
								echo ($tempPage > 1) ? (intval($_POST['activePage']) - 1) : 1;?>&
						sortTurn=<?php echo $_POST['sortTurn']?>'>previous</a>

			<?php
			$maxPages = ceil($_POST['numberOfContacts']/MAX_ON_PAGE);
			$temp = 1;
			while ($temp <= $maxPages): ?>

				<a href='contacts.php?
						sortBy=<?php echo $_POST['sortBy']?>&
						activePage=<?php echo $temp?>&
						sortTurn=<?php echo $_POST['sortTurn']?>'><?php echo $temp?></a>

				<?php
				$temp++;
			endwhile; ?>

			<a href='contacts.php?
						sortBy=<?php echo $_POST['sortBy']?>&
						activePage=<?php $tempPage = (intval($_POST['activePage']));
							echo ($tempPage >= $maxPages) ? $maxPages : (intval($_POST['activePage']) + 1);?>&
						sortTurn=<?php echo $_POST['sortTurn']?>'>next</a>
		</form>
	</body>
</html>
