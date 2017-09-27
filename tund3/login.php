
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
</head>
<body>
	<h2>Logi sisse</h2>
	<form method="POST">
		<label>Kasutajanimi:</label><br>
		<input name="loginEmail" type="email">
		<br><br>
		<input name="loginPassword" placeholder="Salasõna" type="password">
		<br><br>
		<input name="submitUser" type="submit" value="Logi sisse">
	</form>
	
	<h2>Registreeri uus kasutaja </h2>
	<form method="POST">
		<label>Eesnimi:</label><br> <input name="signupFirstName" type="text">
		<br><br>
		<label>Perekonnanimi:</label><br> <input name="signupFamilyName" type="text">
		<br><br>
		<label>Mees:</label><input type="radio" name="gender" value="1" checked> 
		<label>Naine:</label><input type="radio" name="gender" value="2">
		<br><br>
		<label>Email:</label><br> <input name="signupEmail" tyle="email">
		<br><br>
		<label>Parool:</label><br> <input name="signupPassword" type="password">
		<br>
		<p><input name="submitNewUser" type="submit" value="Registreeri"></p>
	</form>
</body>
</html>
