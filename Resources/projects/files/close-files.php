<?php
$getCloseFilesText = function($isDesktopDocs)
{
    $env = $isDesktopDocs ? "VS Code" : "the IDE" ;
    echo "
<p>To close a file, at the top of {$env}, click the <span class='button-name'>x</span> button on the file tab you want to close.</p>
<p>To close all of the files in a project, at the top of {$env}, right-click one of the file tabs and then click <span class='button-name'>Close All</span>.</p>
    ";
}
?>