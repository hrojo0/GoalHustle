@extends('adminlte::page')
@section('title', 'Manage tournaments')

@section('content_header')
    <h2>Manage Tournaments</h2>
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
        <a class="btn btn-primary" href="{{ route('tournaments.create') }}">Add tournament</a>
        
    </div>

    <div class="card-body">
        <table id="tournaments-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Season</th>
                    <th>Rounds</th>
                    <th>Featured</th>
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
                    url: '{{ route('tournaments.search') }}',
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
                                <a href="/tournament/${row.slug}" target="_blank">${data}</a>
                            `;
                        }
                     },
                    { data: 'season' },
                    { data: 'rounds' },
                    { data: 'featured',
                        render: function(data, type, row){
                                return `<input type="checkbox" class="form-check-input ml-4"
                                 ${data ? 'checked="checked"' : ''} disabled>`;
                        }
                    },
                    {
                        data: 'slug',
                        render: function(data, type, row) {
                            return `
                                @can('tournaments.edit')
                                    <a href="tournaments/${data}/edit" class="btn btn-primary btn-sm">Edit</a>
                                @endcan
                                
                                <a href="tournaments/${data}/teams" class="btn btn-primary btn-sm">Teams</a>

                                @can('tournaments.destroy')
                                    <form action="tournaments/${data}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                                    </form>
                                @endcan
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
                    searchPlaceholder: "Search tournaments by name"
                }
            });

            $('#search').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
@stop
