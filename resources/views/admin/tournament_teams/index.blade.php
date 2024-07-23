@extends('adminlte::page')
@section('title', 'Manage games')

@section('content_header')
    <h2>Manage Games for {{ $tournament->name}}</h2>
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
@endif

<div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="{{ route('tournamentTeam.create', $tournament->slug) }}">Add team</a>
    </div>

    <div class="card-body">
        <table id="tournaments-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Team</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <!-- DataTables will automatically fill this -->
            </tbody>
        </table>
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
            var table = $('#tournaments-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('tournamentTeam.search') }}',
                    type: 'POST',
                    data: function(d) { //passing parameters to ajax
                        d._token = '{{ csrf_token() }}';
                        d.query = $('#search').val();
                        d.tournament_id = '{{$tournament->id}}';
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
                                <a href="/admin/tournamentTeams/${row.id}/edit" class="btn btn-primary btn-sm">Change team</a>
                                <form action="/admin/tournamentTeams/${row.id}" method="POST" style="display:inline;">
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
                pageLength: 25,
                language: {
                    searchPlaceholder: "Search teams by name"
                }
            });

            $('#search').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
@stop
