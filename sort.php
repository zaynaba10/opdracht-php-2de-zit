<?php
$sortOrder = 'ASC';
$sortType = 'name';

if (isset($_GET['sort']) && in_array($_GET['sort'], ['ascending', 'descending'])) {
    $sortOrder = $_GET['sort'] == 'ascending' ? 'ASC' : 'DESC';
}

if (isset($_GET['type']) && in_array($_GET['type'], ['name', 'deadline'])) {
    $sortType = $_GET['type'];
}

$listsQuery = $pdo->prepare("SELECT * FROM tasks ORDER BY $sortType $sortOrder");
$listsQuery->execute();

$taskSortOrder = 'ASC';
$taskSortType = 'deadline';

if (isset($_GET['sort']) && in_array($_GET['sort'], ['ascending', 'descending'])) {
    $taskSortOrder = $_GET['sort'] == 'ascending' ? 'ASC' : 'DESC';
}

if (isset($_GET['type']) && in_array($_GET['type'], ['name', 'deadline'])) {
    $taskSortType = $_GET['type'];
}
?>