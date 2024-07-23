@extends('adminlte::page')
@section('title', 'Add team')

@section('content_header')
    <h2>Add team to {{$tournament->name}}</h2>
@stop

@section('css')
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
@endsection

@section('js')
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
@endsection


@section('content')
    <div class="card">
        <div class="card-body">
            @if($teams->isEmpty())
                <div class="alert alert-warning">
                    There are no teams left to select.
                </div>
                <a href="{{ route('tournamentTeam.index', $tournament->slug) }}">
                    <x-bladewind::button uppercasing="false">
                        Regresar
                    </x-bladewind::button>
                </a>
            @else
                <form method="POST" action="{{ route('tournamentTeam.store', $tournament->slug) }}" enctype="multipart/form-data">
                    @csrf 

                    <div class="form-group"><input type="hidden" name="tournament_id" value="{{ $tournament->id }}"></div>

                    <div class="form-group">
                        <select class="form-control" name="team_id" id="team_id">
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }}
                                </option>
                            @endforeach
                            
                        </select>
        
                        
                        <x-input-error :messages="$errors->get('team_id')" class="mt-2 text-danger" />
                        
                    </div>


                    <input type="submit" value="Add team" class="btn btn-primary">
                </form>
            @endif
        </div>
    </div>
@stop