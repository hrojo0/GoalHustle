@extends('adminlte::page')

@section('title')
Change team | {{ $tournamentTeam->tournament->name }}
@endsection
@section('content_header')
    <h2>Change team of tournament {{ $tournamentTeam->tournament->name }}</h2>
@endsection

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
            <a href="{{route('tournamentTeam.index', $tournamentTeam->tournament->slug)}}">
                <x-bladewind::button uppercasing="false">
                    Regresar
                </x-bladewind::button>
            </a>
        @else
            <form method="POST" action="{{ route('tournamentTeam.update', $tournamentTeam->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group"><input type="hidden" name="id" value="{{ $tournamentTeam->id }}"></div>
                
                <div class="form-group">
                    <select class="form-control" name="team_id" id="team_id">
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}" {{ $tournamentTeam->team_id == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                        @endforeach
                        
                    </select>

                    
                    <x-input-error :messages="$errors->get('team_id')" class="mt-2 text-danger" />
                    
                </div>
                <x-bladewind::button can_submit="true" uppercasing="false">
                    Change team
                </x-bladewind::button>
                <input type="submit" value="Change team" class="btn btn-primary">    
            </form>
        @endif
    </div>
</div>
@endsection