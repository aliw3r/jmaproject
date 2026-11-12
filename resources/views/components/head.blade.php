<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Japanese Music Awards</title>
    <meta name="description" content="Japanese Music Awards - платформа для ценителей японской музыки. Рейтинги, премии, рецензии.">
    <meta name="keywords" content="японская музыка, JMA, премия, рейтинг, MELO">
    <meta name="author" content="Japanese Music Awards">

    <link href="{{ asset('storage/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('storage/img/other/favicon-96x96.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/img/other/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('storage/img/other/site.webmanifest') }}">

    <!-- Цвет темы для браузеров -->
    <meta name="msapplication-TileColor" content="#141414">
    <meta name="theme-color" content="#141414">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="JMA - Japanese Music Awards">
    <meta property="og:description" content="Japanese Music Awards - платформа для ценителей японской музыки.">
    <meta property="og:image" content="{{ asset('storage/img/other/og-image.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="JMA">
    <meta property="og:locale" content="ru_RU">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="JMA - Japanese Music Awards">
    <meta name="twitter:description" content="Japanese Music Awards - платформа для ценителей японской музыки.">
    <meta name="twitter:image" content="{{ asset('storage/img/other/og-image.jpg') }}">

</head>