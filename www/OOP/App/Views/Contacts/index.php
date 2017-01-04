<?php

	function turnSide($turn){
		return ($turn == "ASC") ? "DESC" : "ASC";
	};

	function getSortArrows($turn){
		return ($turn == "ASC") ? "down-arrow" : "up-arrow" ;
	};

	function getHref($sortBy, $activePage, $sortTurn){
		$str = "/contacts?";
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
								<a href=<?php echo getHref("firstname", $activePage, $sortTurn); ?>>First
								<div id=
									<?php echo ($sortBy == "firstname")
										? getSortArrows($sortTurn)
										: "no-img";
									?>>
								</div>
								</a>
							</th>
							<th class="th-lastname">
								<a href=<?php echo getHref("lastname", $activePage, $sortTurn); ?>>Last
								<div id=
									<?php echo ($sortBy == "lastname")
										? getSortArrows($sortTurn)
										: "no-img";
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
					<div class="pagination-block">
						<div class="previous-a">
							<?php 
								if ($activePage != 1): 
							?>
								<a href='/contacts?
									sortBy=<?php echo $sortBy?>&
									activePage=<?php $tempPage = (intval($activePage));
											echo ($tempPage > 1) ? (intval($activePage) - 1) : 1;?>&
									sortTurn=<?php echo $sortTurn?>'>
									
									<div class="previous-img"></div>
									
									<p>previous</p>
								</a>
							<?php endif; ?>
						</div>
						<div class="pages-block">
							<div>
								<p>page: </p>

								<?php
								$temp = 1;
								$maxPages = ceil($numberOfAllFields/$maxOnPage);
								while ($temp <= $maxPages): ?>

									<a <?php echo ($temp == $activePage)
												? "style='color:white'"
												: null; ?>
										href='/contacts?
											sortBy=<?php echo $sortBy?>&
											activePage=<?php echo $temp?>&
											sortTurn=<?php echo $sortTurn?>'><?php echo $temp?></a>

									<?php
									$temp++;
								endwhile; ?>
							</div>
						</div>
						<div class="next-a">
							<?php
								if ($maxPages != $activePage): ?>
									<a href='/contacts?
										sortBy=<?php echo $sortBy?>&
										activePage=<?php $tempPage = (intval($activePage));
										echo ($tempPage >= $maxPages) ? $maxPages : (intval($activePage) + 1);?>&
										sortTurn=<?php echo $sortTurn?>'>
										
										<p>next</p>
										<div class="next-img"></div>
									</a>
							<?php endif; ?>
						</div>
					</div>
				</div>

			<?php require_once '../App/Views/Elements/footer.php' ?>
		</div>
	</body>
</html>

<script type="text/javascript">
	function AlertIt(id) {
		var answer = confirm ("Do you realy want to delete record with id: " + id)
		if (answer){
			if (typeof (id) == "number"){
				window.location="/contacts/delete/" + id;
			}
		}
	}
</script>