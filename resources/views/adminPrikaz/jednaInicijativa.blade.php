@extends('layouts.app')


@section('style')

<link href="{!! asset('css/adminStyle.css') !!}" media="all" rel="stylesheet" type="text/css" />

@stop

@section('content')



<h4>Inicijativa za:</h4>
<h4>{{$inicijativa->tip}}</h4>
<h4>Ime i Prezime:</h4>
<h4>{{$inicijativa->imePrezime}}</h4>
<h4>Naziv privrednog subjekta:</h4>
<h4>{{$inicijativa->nazivPrivrednogSubjekta}}</h4>
<h4>Adresa:</h4>
<h4>{{$inicijativa->adresa}}</h4>
<h4>Email:</h4>
<h4>{{$inicijativa->email}}</h4>
<h4>naziv procedure:</h4>
<h4>{{$inicijativa->nazivProcedure}}</h4>
<h4>naziv zalpna:</h4>
<h4>{{$inicijativa->nazivZakona}}</h4>
<h4>naziv clana:</h4>
<h4>{{$inicijativa->nazivClana}}</h4>
<h4>primedbe:</h4>
<h4>{{$inicijativa->primedbe}}</h4>
<h4>predlog izmene:</h4>
<h4>{{$inicijativa->predlogIzmene}}</h4>

@stop