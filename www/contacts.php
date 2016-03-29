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
			$contacts = getContacts($_GET['activePage']);
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


			<!--
			function buildPagination() {
			var selPage = app.data.selectedTab;
			var start = selPage - 5;
			var stop = selPage + 5;
			var maxPage = app.data.maxTab;
			var html = '<ul class="pagination" id="paginationlink">';
				if (start > 1) {html += '<li><a href="#1">1...</a></li>';}
				for (var i = start; i <= stop; i++) {
				if (i >= 1 && i <= maxPage) {
				i == selPage ? html += '<li class="active"><a href="#' + i +'">' + i +'</a></li>' : html += '<li><a href="#' + i +'">' + i +'</a></li>';
				}
				}
				if (stop < maxPage) {html += '<li><a href="#' + maxPage +'">...' + maxPage + '</a></li>';}
				html += '</ul>';
			return html;
			}
			-->
			<?php

			$maxPages = ceil($_POST['numberOfContacts']/MAX_ON_PAGE);
			$temp = 1;
			while ($temp <= $maxPages) {
				$tempUrl = "controller.php?activePage=".$temp;
				?>

				<a href='controller.php?activePage=<?php echo $temp?>'><?php echo $temp?></a>

				<?php
				$temp++;
			};

			?>

		</form>
	</body>
</html>