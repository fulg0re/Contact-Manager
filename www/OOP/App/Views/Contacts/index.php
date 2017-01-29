<?php

	function turnSide($turn){
		return ($turn == "ASC") ? "DESC" : "ASC";
	};

	function getRout(){
		return "/contacts";
	};

	function getSortArrows($turn){
		return ($turn == "ASC") ? "down-arrow" : "up-arrow" ;
	};

	function getHref($sortBy, $activePage, $sortTurn){
		$str = getRout()."?";
		$str .= "sortBy=$sortBy&";
		$str .= "activePage=$activePage&";
		$str .= "sortTurn=" . turnSide($sortTurn);

		return $str;
	};
?>

<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/Contacts</title>

		<?php require_once '../App/Views/Elements/head.php' ?>

	</head>
	<body>
		<div class='body-div'>
			<?php require_once '../App/Views/Elements/header.php' ?>

			<!-- message part -->
			<?php require_once '../App/Views/Elements/message.php' ?>
		
			<?php if (!isset($noContacts)): ?>
				<div class="table-div">
				
					<a class="add-button-a" href='/contacts/add'>
						<div class="add-button">
							<p>ADD</p>
						</div>
					</a>

					<table>
						<tr>
							<th class="th-id"></th>
							<th class="th-firstname">
								<a href="<?php echo getHref("firstname", $activePage, $sortTurn); ?>">First
								<div id=
									<?php echo ($sortBy == "firstname")
										? getSortArrows($sortTurn)
										: "firstnameNoImg";
									?>>
								</div>
								</a>
							</th>
							<th class="th-lastname">
								<a href="<?php echo getHref("lastname", $activePage, $sortTurn); ?>">Last
								<div id=
									<?php echo ($sortBy == "lastname")
										? getSortArrows($sortTurn)
										: "lastnameNoImg";
									?>>
								</div>
								</a>
							</th>
							<th class="th-email">Email</th>
							<th class="th-best-phone">Best Phone</th>
							<th class="th-action">Actions</th>
						</tr>
						<?php foreach ($contacts as $v): ?>
							<tr>
								<td><?php echo $v['id']?>.</td>
								<td><?php echo $v['firstname']?></td>
								<td><?php echo $v['lastname']?></td>
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
								<td>
									<a href='/contacts/edit/<?php echo $contactId ?>'>
										<div class="edit-button">
											<p>edit</p>
										</div>
									</a>
								</td>
								<td>
									<a href='javascript:AlertIt(<?php echo $contactId ?>);'>
										<div class="delete-button">
											<p>X</p>
										</div>
									</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
				<?php else: ?>
					<h2><?php echo $noContacts ?></h2>
				<?php endif; ?>

				<?php require_once '../App/Views/Elements/pagination.php' ?>

				</div>

			<?php require_once '../App/Views/Elements/footer.php' ?>
		</div>
	</body>
</html>