<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="{url type=assets url=css}bootstrap.min.css">
        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <link rel="stylesheet" href="{url type=assets url=css}bootstrap-responsive.min.css">
        <link rel="stylesheet" href="{url type=assets url=css}fineuploader-3.4.1.css">
        <link rel="stylesheet" href="{url type=assets url=css}main.css">

        <script src="{url type=assets url=js}modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <div class="container">

            <!-- Main hero unit for a primary marketing message or call to action -->
            <div class="hero-unit">
                <h1>Convert deck to BA format</h1>
                <p>You just need top select you deck(s) and you'll get a link with the good format, you can also directly drop decks on this page.</p>
                <div id="upload" class="row-fluid clearfix"></div>
                <form target="_blank" class="row-fluid hidden" action="{url url="site/download_all"}" method="post" id="download_all">
                    <input type="submit" class="btn btn-info" href="/" value="Download all as zip">
                </form>
            </div>
            <p class="span12 text-small">
                All files will be deleted from the server after one hour.
            </p>
        </div>

        <hr>

        <footer>
            <p class="span12">This project is <a href="https://github.com/Korri/ba-import">open-source</a>, created by Korri</p>
        </footer>

    </div> <!-- /container -->

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="{url type=assets url=js}jquery-1.9.1.min.js"><\/script>')</script>

    <script src="{url type=assets url=js}bootstrap.min.js"></script>
    <script src="{url type=assets url=js}jquery.fineuploader-3.4.1.js"></script>
    <script>
        var PHP_UPLOADER = '{url url="site/upload"}/';
        var PHP_DOWNLOAD = '{url url="site/download"}/';
    </script>
    <script src="{url type=assets url=js}main.js"></script>
</html>
