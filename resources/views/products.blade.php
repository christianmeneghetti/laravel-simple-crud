@extends('layouts.main')

@section('title', 'Produtos')

@section('content')

    <h1 style="text-align: center">Pagina de produtos</h1>

    <div class="container container-fluid">
        <form action="/products/p">
            <div class="form-group">
                <label for="search">Pesquise: </label>
                <input type="text" name="search" class="form-control" id="search" placeholder="Ex: Camisa">
            </div>
            <button type="submit" class="btn btn-primary">Pesquisar</button>
        </form>
    </div>
    
    <a href="/">Home</a>

@endsection