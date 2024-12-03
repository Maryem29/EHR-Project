<?php
session_start();
session_destroy();
header('Location: logout.html'); // Or another page like login.html
exit;

