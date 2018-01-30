<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <title>KomfortTV</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Style-Type" content="text/css" />

        <meta property="og:image" content="/html/images/logo-kartina.png" />

        <script src="https://apis.google.com/js/plusone.js" type="text/javascript" ></script>    

        <?= $this->header() ?>
        <?= $this->css() ?>
        <?= $this->js() ?>
    </head>

    <body ng-app="app">
        <script>
           var app = angular.module("app",[]);
        </script>
        <?=$this->module('header')?>
        <?=$this->maincontent?>        
        <?=$this->module('footer')?>
    </body>
</html>
