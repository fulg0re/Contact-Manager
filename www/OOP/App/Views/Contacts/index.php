<?php
	function turnSide($turn){
		return ($turn == "ASC") ? "DESC" : "ASC";
	};

	function inputImage($turn){
		return ($turn == "ASC") ? IMG_SORT_BY_ASC : IMG_SORT_BY_DESC ;
	};
?>

<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/Contacts</title>
		<link rel="stylesheet" href="/css/main.css">
	</head>
	<body>
        <!-- error part -->
		<div class='err'><h3><?php echo (isset($message)) ? $message : null;?></h3></div>
		<a href='/contacts/logout'>logout</a>
		<h3>MANAGEMENT MAIN PAGE</h3>
		<form action="/contacts/add" method="post">
			<a href='/selection/index'>selectionPage</a><br><br>
			<input type="submit" name="addNewContact" value="ADD"></br>
			<?php if (!isset($noContacts)): ?>
				<table style="border: 1px solid">
					<tr>
						<th><a href="/contacts/posts?
							sortBy=lastname&
							activePage=<?php echo $activePage?>&
							sortTurn=<?php echo turnSide($sortTurn);?>">Last
								<img src='<?php echo ($sortBy == "lastname") ? inputImage($sortTurn) : "";?>' />
							</a></th>
						<th><a href="/contacts/posts?
							sortBy=firstname&
							activePage=<?php echo $activePage?>&
							sortTurn=<?php echo turnSide($sortTurn);?>">First
								<img src='<?php echo ($sortBy == "firstname") ? inputImage($sortTurn) : "";?>' />
							</a></th>
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
							<td><a href='/contacts/edit?editId=<?php echo $contactId?>'>edit/view</a></td>
							<td><a href='/contacts/delete?
								deleteId=<?php echo $contactId?>&
								activePage=<?php 
									echo (count($contacts) > 1) ? $activePage : $activePage - 1 
									?>&
								sortTurn=<?php echo $sortTurn;?>&
								sortBy=<?php echo $sortBy?>'>delete</a></td>
						</tr>
					<?php endforeach; ?>
				</table>
			<?php else: ?>
				<h2><?php echo $noContacts ?></h2>
			<?php endif; ?>
			<input type="submit" name="addNewContact" value="ADD"></br></br>

			<a href='/contacts/posts?
						sortBy=<?php echo $sortBy?>&
						activePage=<?php $tempPage = (intval($activePage));
								echo ($tempPage > 1) ? (intval($activePage) - 1) : 1;?>&
						sortTurn=<?php echo $sortTurn?>'>previous</a>

			<?php
			$maxPages = ceil($numberOfAllFields/$maxOnPage);
			$temp = 1;
			while ($temp <= $maxPages): ?>

				<a href='/contacts/posts?
						sortBy=<?php echo $sortBy?>&
						activePage=<?php echo $temp?>&
						sortTurn=<?php echo $sortTurn?>'><?php echo $temp?></a>

				<?php
				$temp++;
			endwhile; ?>

			<a href='/contacts/posts?
						sortBy=<?php echo $sortBy?>&
						activePage=<?php $tempPage = (intval($activePage));
							echo ($tempPage >= $maxPages) ? $maxPages : (intval($activePage) + 1);?>&
						sortTurn=<?php echo $sortTurn?>'>next</a>
		</form>
	</body>
</html>