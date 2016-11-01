<?php

	function turnSide($turn){
		return ($turn == "ASC") ? "DESC" : "ASC";
	};

	function getSortArrows($turn){
		return ($turn == "ASC") ? " ⇓" : " ⇑" ;
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
		<div id='body-div'>
			<?php require_once '../App/Views/Elements/header.php' ?>

			<!-- message part -->
			<?php require_once '../App/Views/Elements/message.php' ?>
		
			<form action="/contacts/add" method="post">
				<?php if (!isset($noContacts)): ?>
					<div id="table-div">
						<input id="add-button" type="submit" name="button" value="ADD"></br>

						<table>
							<tr>
								<th id="th-id"></th>
								<th id="th-firstname"><a href=<?php echo getHref("firstname",$activePage, $sortTurn); ?>>First
									<?php echo ($sortBy == "firstname") 
											? getSortArrows($sortTurn) 
											: null;
									?>
									</a></th>
								<th id="th-lastname"><a href=<?php echo getHref("lastname",$activePage, $sortTurn); ?>>Last
									<?php echo ($sortBy == "lastname") 
											? getSortArrows($sortTurn) 
											: null;
									?>
									</a></th>
								<th id="th-email">Email</th>
								<th id="th-best-phone">Best Phone</th>
								<th id="th-action">Actions</th>
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
										<a href='/contacts/delete/<?php echo $contactId ?>?
											activePage=<?php 
											echo (count($contacts) > 1) ? $activePage : $activePage - 1 
											?>&
											sortTurn=<?php echo $sortTurn;?>&
											sortBy=<?php echo $sortBy?>'>
											
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
						<div id="pagination-block">
							<div id="previous-a">
								<a href='/contacts?
									sortBy=<?php echo $sortBy?>&
									activePage=<?php $tempPage = (intval($activePage));
											echo ($tempPage > 1) ? (intval($activePage) - 1) : 1;?>&
									sortTurn=<?php echo $sortTurn?>'>
									
									<img src="/images/previous.png" id="previous-img"/>
									<p>previous</p>
								</a>
							</div>
							<div id="pages-block">
								<p>page: </p>

								<?php
								$maxPages = ceil($numberOfAllFields/$maxOnPage);
								$temp = 1;
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
							<div id="next-a">
								<a href='/contacts?
									sortBy=<?php echo $sortBy?>&
									activePage=<?php $tempPage = (intval($activePage));
										echo ($tempPage >= $maxPages) ? $maxPages : (intval($activePage) + 1);?>&
									sortTurn=<?php echo $sortTurn?>'>
									
									<p>next</p>
									<img src="/images/next.png" id="next-img"/>
								</a>
							</div>
						</div>
					</div>
			</form>

			<?php require_once '../App/Views/Elements/footer.php' ?>
		</div>
	</body>
</html>
