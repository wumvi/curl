<?php
echo 'r=', $_SERVER['REQUEST_METHOD'], ' ';
echo 'q=', $_SERVER['QUERY_STRING'] ?? '', ' ';
echo 'ht=', $_SERVER['HTTP_DATA'] ?? '', ' ';
echo 'pt=', $_POST['test'] ?? '', ' ';