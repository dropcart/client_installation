<?php

/**
 * THEME: DEFAULT
 *
 * @author     DropCart <info@dropcart.nl>
 * @copyright  2017  DropCart
 * @license    https://creativecommons.org/licenses/by-nc-nd/3.0/legalcode.txt  CreativeCommons by-nc-nd-3.0
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index,follow">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Stylesheet -->
    <link href="<?= env('BASE_URL', '/') ?>css/justified-nav.css" rel="stylesheet" />
    <link href="<?= env('BASE_URL', '/') ?>css/bv.min.css" rel="stylesheet" />
    <link href="<?= env('BASE_URL', '/') ?>css/flags.css" rel="stylesheet" />
    <link href="<?= env('BASE_URL', '/') ?>css/custom.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <title>
        @hasSection('page_title')
            @yield('page_title') -
        @endif
        {{ env('SITE_NAME', 'DropCart Client Website') }}
    </title>
</head>
<body>
<div class="colorgraph"></div>

<div class="container">

    <div class="row">
        <div class="col-md-6">
            <div class="push-left">
            <!-- <h3 class="text-muted"><?= env('SITE_NAME'); ?></h3> -->
                <a href="<?= route('home', ['locale' => loc()]); ?>"><img style="max-height: 94px;" src="<?= env('BASE_URL', '/') ?>img/logo_small.png" alt="<?= env('SITE_NAME'); ?>" /></a>
                <h4 class="slogan"><?= env('SITE_SUBTITLE') ?></h4>
            </div>
        </div>
        <div class="col-md-6">
            <div class="push-right">
                <!-- <h3>&nbsp;</h3> -->
                <nav class="float-right">
                    <ul class="nav nav-pills">
                        <li><a href="<?= route('contact', ['locale' => loc()]); ?>">{{ lang('contact') }}</a></li>
                        <li><a href="<?= route('aboutus', ['locale' => loc()]); ?>">{{ lang("aboutus") }}</a></li>
                        <li><a href="<?= route('support', ['locale' => loc()]); ?>">{{ lang('support') }}</a></li>
                        <li><a href="<?= route('account', ['locale' => loc()]); ?>">{{ lang('account') }}</a></li>
                    </ul>
                </nav>
                <div class="float-clear"></div>

            </div>
        </div>
    </div>

    <div class="masthead">
        <nav>
            <ul class="nav nav-justified">
                <li class="no-stretch"><a href="<?= route('home', ['locale' => loc()]); ?>"><b class="glyphicon glyphicon-home"></b></a></li>
                <?php
                global $client;

                $categories = $app['dropcart']->getCategories();
                foreach ($categories as $category):
                ?>
                <li><a href="<?= route('products_by_category', [
                            'locale' => loc(),
                            'category_name' => str_slug($category['name']),
                            'category_id' => $category['id']
                    ]) ?>" title="<?= $category['description'] ?>"><?= $category['name'] ?></a></li>
                <?php
                endforeach
                ?>
            </ul>
        </nav>
    </div>