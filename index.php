<?php
set_include_path("D:\\site_n_1");
echo(str_replace("%php%", file_get_contents("page.html"), file_get_contents("header.html", true)));
?>