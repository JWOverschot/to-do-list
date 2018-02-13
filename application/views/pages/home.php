<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>TO DO LIST</title>
	<!-- <link rel="stylesheet" href=""> -->
</head>
<body>
	<h1>TO-DO Lists</h1>
	<?php foreach ($lists as $list): ?>

		<h3><?php echo $list['Title']; ?></h3>
		
	<?php endforeach; ?>
</body>
</html>