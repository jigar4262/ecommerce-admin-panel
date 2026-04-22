@extends('layouts.app')
@section('title', 'Options')
@section('page-title', 'Options')
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Option Name</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($options as $option)
                                <tr>
                                    <td>{{ $option->id }}</td>
                                    <td>{{ $option->option_name }}</td>
                                    <td>{{ $option->option_type_id }}</td>
                                    <td>
                                        {{ $option->values->pluck('value_name')->implode(',') }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $option->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $option->status == 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('options.edit', $option->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>

                                        <form action="{{ route('options.destroy', $option->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
