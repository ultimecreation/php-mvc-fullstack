<?php
function setUserData($data)
{
    foreach ($data as $key => $value) {
        $_SESSION['user_logged'][$key] = $value;
    }
}
function getUserData($data = null)
{
    if (!$data) return $_SESSION['user_logged'];
    if ($data) return $_SESSION['user_logged'][$data];
    else return "no user connected";
}
function isUserLogged()
{
    if (!empty($_SESSION['user_logged'])) return true;
    return false;
}
function userLogoutRequest()
{
    unset($_SESSION['user_logged']);
}
