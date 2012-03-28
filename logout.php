<?php

if (!isset($_SESSION)) session_start();
$ref = getenv('HTTP_REFERER');

if (isset($_SESSION['username'])) {
	session_unset();
	session_destroy();
	header("Location: " . $ref);
} else header("Location: " . $ref);