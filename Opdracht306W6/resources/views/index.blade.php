<?php

require_once 'functions.php';
// Haal alle families op die actief zijn
$status = '';
$sql = "SELECT * FROM familie WHERE status IS NULL OR status = ?";
$familiesResultaat = executePreparedStatement($pdo, $sql, $status);
//print_r($familiesResultaat); // Controleren of de data wel wordt opgehaald uit DB

?>

<?php include 'layout.php' ?>

@extends('layouts.main')
@extends('layouts.LinkScript')


@section('content')
<div id="main-content">
    <h1>Families Overzicht</h1>
    <table>
        <tr>
            <th>Familie ID</th>
            <th>Naam</th>
            <th>Adres</th>
            <th>Acties</th>
        </tr>
        @foreach ($familiesResultaat as $familie)
            <tr>
                <td>{{ $familie['id'] }}</td>
                <td>{{ $familie['naam'] }}</td>
                <td>{{ $familie['adres'] }}</td>
                <td>
                    <form method="post" action="functions.php">
                        <a href="view_familie.php?id={{ $familie['id'] }}">Bekijken |</a>
                        <a href="update_familie.php?id={{ $familie['id'] }}">Bewerken |</a>
                        <input type="hidden" name="familie_id" value="{{ $familie['id'] }}"> 
                        <input type="submit" name="verwijder_familie" value="Verwijderen">
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</div>   
@endsection




<nav class="navbar navbar-default">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">Brand</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Link</a></li>
                <li class="dropdown">
