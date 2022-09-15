<?php 
include(DOCS_RESOURCES."/get-vimeo-player.php"); 
$getVimeoPlayerText(696287618);
?>

<p>Algorithm parameters are hard-coded values for variables in your project that are set outside of the project files. <a href="/docs/v2/our-platform/projects/getting-started#10-Edit-Parameters">Add parameters to your projects</a> to remove hard-coded values from your code files and to perform <a href="/docs/v2/our-platform/optimization">parameter optimizations</a>. To get the parameter value into your algorithm in the web IDE, use the <code>GetParameter</code> method. Alternatively, in C# projects, you can apply the <code>Parameter</code> attribute to define public class members with algorithm parameter values. The parameter values are sent to your algorithm when you deploy the algorithm, so it's not possible to change the parameter values while the algorithm runs.</p>