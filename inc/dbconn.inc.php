<?php

mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die('Unable to connect to database');
mysql_select_db(DB_DATABASE) or die('Unable to select database');

define('SYSTEM_VERSION','1.9c');
?>