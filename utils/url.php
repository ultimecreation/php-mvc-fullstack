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
