<?php

foreach (glob(__DIR__ . '/app/*.php') as $route_file) {
  require $route_file;
}

foreach (glob(__DIR__ . '/cms/*.php') as $route_file) {
  require $route_file;
}
