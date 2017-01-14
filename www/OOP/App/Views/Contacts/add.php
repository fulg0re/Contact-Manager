<?php
	function getFormAction(){
		return "/contacts/add";
		//return "/contacts/newChanges";
	};

	function getButtonName(){
		return "ADD";
	};
?>

<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/Edit</title>

		<?php require_once '../App/Views/Elements/head.php' ?>

	</head>
	<body>
		<div class='body-div'>

			<?php require_once '../App/Views/Elements/header.php' ?>

			<!-- message part (Elements/message.php) -->
			<?php require_once '../App/Views/Elements/message.php' ?>

			<?php $formAction = getFormAction(); ?>
			
			<?php require_once '../App/Views/Elements/addEditDetails.php' ?>

			<?php require_once '../App/Views/Elements/footer.php' ?>
		</div>
	</body>
</html>
