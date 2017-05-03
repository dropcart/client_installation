<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Error 404 - Not Found</title>
    <meta name="viewport" content="width=device-width">
    <style type="text/css">
        @import url(http://fonts.googleapis.com/css?family=Droid+Sans);
        body
        {
            font-family:'Droid Sans', sans-serif;
            font-size:10pt;
            color:#555;
            line-height: 25px;
        }

        .error-page {padding: 40px 15px;text-align: center;}
        .error-actions {margin-top:15px;margin-bottom:15px;}
        .error-actions .btn { margin-right:10px; }
        .error { font-size :80px; margin-top:40px; margin-bottom:40px;}
    </style>
</head>
<body>
<div class="wrapper row2">
    <div class="error-page">
        <h2>Oops!</h2>
        <h1 class="error"> 404 </h1>
        <h2>Not Found</h2>
        <div class="error-details">
            Sorry, an error has occured. Requested page not found!
        </div>
        <a href="<?= route('home', ['locale' => loc()]); ?>"><img style="max-height: 94px;"
                                                                  src="<?= route('home', ['locale' => loc()]); ?>/images/logo.png"
                                                                  alt="<?= env('SITE_NAME'); ?>"/></a>
    </div>
</div>
</body>
</html>