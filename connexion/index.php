<?php
set_include_path($_SERVER['DOCUMENT_ROOT']."/projet_site");
echo(str_replace("dos", "active", str_replace("%php%", file_get_contents("page.html"), file_get_contents("header.html", true))));
?>