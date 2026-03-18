<?php
    class Services {
        public static function navigateTo($route) {
            include ROOT . $route;
            exit();
        }

    }

?>