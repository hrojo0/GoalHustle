@extends('adminlte::page')
@section('title', 'Manage games')

@section('content_header')
    <h2>Manage games
    </h2>
@stop

@section('content')
@if (session('success-create'))
    <div class="alert alert-info">
        {{ session('success-create') }}
    </div>
@elseif (session('success-update'))
    <div class="alert alert-info">
        {{ session('success-update') }}
    </div>
@elseif (session('success-delete'))
    <div class="alert alert-info">
        {{ session('success-delete') }}
    </div>
@elseif (session('success-games'))
    <div class="alert alert-info">
        {{ session('success-games') }}
    </div>
@elseif (session('failed-generate'))
    <div class="alert alert-info">
        {{ session('failed-generate') }}
    </div>
@endif

<div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="{{ route('games.create') }}">Add game</a>
        
    </div>

    <div class="card-body" id="card-body">
        <div class="form-group">
            <label for="tournament">Load tournament games</label>
            <select class="form-control" name="tournament" id="tournament">                    
                <option value="" id="tournament_first">Pick a tournament</option>
                @foreach ($tournaments as $tournament)
                    <option value="{{ $tournament->id }}">
                        {{ $tournament->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('team_id')" class="mt-2 text-danger" />
            
        </div>

        
    </div>
</div>
@stop

@section('js')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table;
            var flag = 0;
            $('#tournament').on('change', function() {
                var tournamentName = $('#tournament option:selected').text();
                $('#tournament_first').text('All tournaments');
                var tournamentId = $(this).val();
                
                /*if ($.fn.DataTable.isDataTable('#games-table')) {}*/
                //check first load of data
                if(flag == 0){
                    $('#card-body').append(`
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#generateModal">
                            Generate Games
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="generateModal" tabindex="-1" role="dialog" aria-labelledby="generateModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="generateModalLabel">Generate games for <span class="tournament_name_generate"></span></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    If this option is applied, it'll erase all the games and generate new ones for the tournament <span class="tournament_name_generate"></span> whit the teams associated with it.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <form id="generate-games-form" method="post" action="{{ route('games.generateGames') }}">
                                        @csrf
                                        <input type="hidden" name="tournament_id" id="tournament_id">
                                        <button type="submit" class="btn btn-primary">Generate</button>
                                    </form>
                                </div>
                                </div>
                            </div>
                            </div>
                            
                        `);
                } else {
                    table.destroy();
                    $('#games-table').remove();
                }
                $('#tournament_name_generate').text(tournamentName);
                $('#tournament_id').val(tournamentId);
                //load datatable
                $('#card-body').append(`
                        <table id="games-table" class="table table-striped">
                            <thead>
                                <tr><th>Tournament</th><th>Home Team</th><th>Away Team</th><th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>`);
                table = $('#games-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('games.gamesPerTournament') }}',
                        type: 'POST',
                        data: function(d) {
                            d._token = '{{ csrf_token() }}';
                            d.tournament = $('#tournament').val();
                        }
                    },
                    columns: [
                        { data: 'tournament',
                            render: function(data, type, row){
                                return `
                                    <a href="/tournament/${row.tournamentSlug}" target="_blank">${data}</a>
                                `;
                            }
                        },
                        { data: 'homeTeam',
                            render: function(data, type, row){
                                return `
                                    <a href="/team/${row.homeTeamSlug}" target="_blank">${data}</a>
                                `;
                            }
                        },
                        { data: 'awayTeam',
                            render: function(data, type, row){
                                return `
                                    <a href="/team/${row.awayTeamSlug}" target="_blank">${data}</a>
                                `;
                            }
                        },
                        {
                            data: 'game',
                            render: function(data, type, row) {
                                return `
                                    <a href="games/${data}/edit" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="games/${data}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                                    </form>
                                `;
                            },
                            orderable: false,
                            searchable: false
                        }
                    ],
                    search: {
                        caseInsensitive: true
                    },
                    order: [[0, 'asc']],
                    pageLength: 50,
                    language: {
                        searchPlaceholder: "Search games by team"
                    }
                });
                flag = 1;
                
            });
            function search(){
                var table = $('#teams-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('teams.search') }}',
                        type: 'POST',
                        data: function(d) {
                            d._token = '{{ csrf_token() }}';
                            d.query = $('#search').val();
                        }
                    },
                    columns: [
                        { data: 'name',
                            render: function(data, type, row){
                                return `
                                    <a href="/team/${row.slug}" target="_blank">${data}</a>
                                `;
                            }
                        },
                        {
                            data: 'slug',
                            render: function(data, type, row) {
                                return `
                                    <a href="teams/${row.game}/edit" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="teams/${rowl.game}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                                    </form>
                                `;
                            },
                            orderable: false,
                            searchable: false
                        }
                    ],
                    search: {
                        caseInsensitive: true
                    },
                    order: [[0, 'asc']],
                    pageLength: 50,
                    language: {
                        searchPlaceholder: "Search players by name"
                    }
                });
             }

            $('#search').on('keyup', function() {
                table.search(this.value).draw();
            });
            setTimeout(function(){
                $('.alert-info').fadeOut(); 
            }, 5000);
        });
    </script>
@stop
