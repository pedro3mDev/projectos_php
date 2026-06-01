<!DOCTYPE html>
	<html lang="pt">
		<head>
			<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
			<meta charset="UTF-8"/>

                </head>
<?php
	session_start();
	session_destroy();
		header("Location: index.php");
?>

        </html>