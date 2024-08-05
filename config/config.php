<?php
$host = 'localhost';
$db = 'todo_app';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $db :" . $e->getMessage());
}

//function to output in chrome debug
function debugclg($data, $context = 'Debug in Console')
{
    ob_start();
    $output = 'console.info(\'' . $context . ':\');';
    $output .= 'console.log(' . json_encode($data) . ');';
    $output = sprintf('<script>%s</script>', $output);
    echo $output;
}
?>