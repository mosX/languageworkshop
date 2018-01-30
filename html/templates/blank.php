<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">
        <meta name="Keywords" content="Форекс, Биржа Форекс, Бинарные Опционы, торговля акциями, Биржа">
        <meta name="description" content="Надежная торговая платформа бинарных опционов с доходностью до 86%. Доступные инструменты для ведения торговли, обучающие материалы и простой в использовании интерфейс. "/>
        <?= $this->header() ?>
        <?= $this->css() ?>
        <?= $this->js() ?>

        <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400|Roboto&amp;subset=latin,cyrillic-ext' rel='stylesheet' type='text/css' />
        <script>
            $(document).ready(function(){
                Time.init(new Date().getTime() - new Date("<?= date('d M Y H:i:s') ?>").getTime());
            });
        </script>
    </head>

    <body>
        
        <?=$this->maincontent?> 
    <!-- Yandex.Metrika counter --><script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter28495676 = new Ya.Metrika({ id:28495676, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/28495676" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
    </body>
</html>