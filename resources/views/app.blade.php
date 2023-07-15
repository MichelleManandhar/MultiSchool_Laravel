<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
       <link href = '{{asset('fontawesome/css/all.min.css')}}' rel="stylesheet">
        <title>SchoolManagement</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body >
            <div id="app"></div>
    <script src="{{asset('js/app.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    </body>
</html>
