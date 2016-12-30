<?php

global $client;
global $category;

$products = $client->getProductListing($category);
print("<h1>Product listing</h1>");
print("<pre>");
print_r($products);
print("</pre>");
