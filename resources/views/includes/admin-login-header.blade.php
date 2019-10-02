<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{ config('app.name', 'CASHGW') }}</title>
        {{-- admin  css --}}
            <link href="/public/css/font-awesome.css" rel="stylesheet">
            <link href="/public/css/ionicons.css" rel="stylesheet">
            <link rel="stylesheet" href="/public/css/slim.css">     
        {{-- admin  css end --}}    
    </head>
    <body>
