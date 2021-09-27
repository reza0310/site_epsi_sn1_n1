<?php
set_include_path("C:\\UwAmp\\www\\my-app");
echo(str_replace("%php%", file_get_contents("page.html"), file_get_contents("header.html", true)));
?>