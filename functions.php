<?php
include_once "config.php";
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$connection) {
    throw new Exception("Not Connected<br>");
}

function getStatusIdForAction($sessionId)
{
    global $connection;
    $query = "SELECT status FROM myclass where id='{$sessionId}' LIMIT 1";
    $val = mysqli_query($connection, $query);
    $value = '';
    while ($data = mysqli_fetch_assoc($val)) {
        $value = $data['status'];
    }
    return $value;

}

function getStatusIdForStatusField($id)
{
    global $connection;
    $query = "SELECT status FROM myclass where id='{$id}' LIMIT 1";
    $val = mysqli_query($connection, $query);
    while ($data = mysqli_fetch_assoc($val)) {
        $value = $data['status'];
    }
    return $value;
}

function getdataofloginuser($id)
{
    global $connection;
    $q = "SELECT * FROM myclass WHERE id='{$id}' ";
    $res = mysqli_query($connection, $q);
    $data = mysqli_fetch_assoc($res);
    return $data;
}
