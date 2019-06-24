<?php
// create link to public assets
function assetsUrl($assetsPartial)
{
    return $assetsPath = ASSETSURL . $assetsPartial;
}
// create link for <a href>
function linkUrl($sitePartial)
{
    return $sitePath = SITEURL . $sitePartial;
}
function redirectTo($endPath)
{
    $path = SITEURL . $endPath;
    header("Location: {$path}");
}
function getUriParts($num = null)
{
    $uriParts = explode('/', $_GET['url']);
    if ($num === null) return $uriParts;
    return $uriParts[$num];
}
function isHomeUrl()
{
    if ($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] === SITEURL . '/') {
        return true;
    }
    return false;
}
