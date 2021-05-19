@extends('layouts.main')

@section('title', 'Editando: ' . $event->title)

@section('content')

  <div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Editando: {{ $event->title }}</h1>
      <form action="/events/update/{{ $event->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label for="image">Imagem do evento:</label>
          <input type="file" class="form-control-file" id="image" name="image">
          <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}" class="img-preview">
        </div>
        <div class="form-group">
          <label for="title">Evento:</label>
          <input type="text" class="form-control" id="title" name="title" placeholder="Ex: CCXP" value="{{ $event->title }}">
        </div>
        <div class="form-group">
          <label for="date">Data do evento:</label>
          <input type="date" class="form-control" id="date" name="date" value="{{ $event->date->format('Y-m-d') }}">
        </div>
        <div class="form-group">
          <label for="title">Cidade:</label>
          <input type="text" class="form-control" id="city" name="city" placeholder="Ex: Araras" value="{{ $event->city }}">
        </div>
        <div class="form-group">
          <label for="title">O evento é privado?</label>
          <select name="private" id="private" class="form-control">
            <option value="0">Não</option>
            <option value="1" {{ $event->private == 1 ? "selected='selected'" : "" }}>Sim</option>
          </select>
        </div>
        <div class="form-group">
          <label for="title">Descrição:</label>
          <textarea name="description" id="description" class="form-control" placeholder="Ex: Lorem te ipsun">{{ $event->description }}</textarea>
        </div>
        <div class="form-group" id="div-checkbox">
          <label for="title">Adicione itens de infraestrutura:</label>
          <div class="form-group">
            <input type="checkbox" name="items[]" value="Cadeiras"> Cadeiras
          </div>
          <div class="form-group">
            <input type="checkbox" name="items[]" value="Palco"> Palco
          </div>
          <div class="form-group">
            <input type="checkbox" name="items[]" value="Open bar"> Open bar
          </div>
          <div class="form-group">
            <input type="checkbox" name="items[]" value="Open food"> Open food
          </div>
          <div class="form-group">
            <input type="checkbox" name="items[]" value="Brindes"> Brindes
          </div>
        </div>
        <input type="submit" class="btn btn-primary" value="Editar Evento">
      </form>
  </div>

@endsection