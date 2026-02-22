<?php

session_start();
session_destroy();
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
header('Location: ' . $base . '/home');
exit;
