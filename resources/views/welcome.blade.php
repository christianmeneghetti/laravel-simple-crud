@extends('layouts.main')

@section('title', 'CM home')

@section('content')

<div id="search-container" class="col-md-12">
    <h1>Pesquisar eventos</h1>
    <form action="/" method="GET">
        <input type="text" id="search" name="search" class="form-control" placeholder="Ex: PHP">
    </form>
</div>
<div id="events-container" class="col-md-12">
    <div id="events-title">
        @if($search)
            <h2>Buscando por: {{ $search }}</h2>
            <p class="subtitle">Veja os eventos dos próximos dias.</p>
        @else  
            <h2>Próximos Eventos</h2>
            <p class="subtitle">Veja os eventos dos próximos dias.</p>
        @endif
    </div>

    <div id="cards-title" class="row">
        @if (count($events) == 0 && $search)
            <p class="subtitle">Nenhum resultado com {{ $search }}! <a href="/">Ver todos</a></p>
        @elseif(count($events) == 0)
            <p class="subtitle">Não há eventos disponiveis.</p>
        @endif
    </div>
    
    <div id="cards-container" class="row">
        {{-- @php
            var_dump($events);
            die;
        @endphp --}}

        @foreach ($events as $event)
            <div class="card col-md-3">
                <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}">
                <div class="card-body">
                    <p class="card-date">{{ date('d/m/Y', strtotime($event->date))}}</p>
                    <h5 class="card-title">{{ $event->title }}</h5>
                    <p class="card-description">{{ $event->description}}</p>
                    <p class="card-participants">{{ count($event->users) }} participantes.</p>
                    <a href="/events/{{ $event->id }}" class="btn btn-primary">Saber mais</a>
                </div>
            </div>
        @endforeach

    </div>
</div>

@endsection
