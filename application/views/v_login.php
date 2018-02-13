<!DOCTYPE html>
<html>
<head>
	<title>Login KOF</title>
</head>
<body>
       
	<?php echo form_open('login/aksi_login'); ?>		
		<table>
			<tr>
				<td>Username</td>
				<td><input type="text" name="username"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Login"></td>
			</tr>
		</table>
	<?php echo form_close(); ?>
</body>
</html>