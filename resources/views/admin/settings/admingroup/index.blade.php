@extends('layouts.app')
@section('title', 'Admin Group')
@section('page-title', 'Admin Group')
@section('content')
    <section class="section">
        <div class="card">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Group Name</th>
                                <th>Category</th>
                                <th>Permisson</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admin_groups as $admin_group)
                                <tr>
                                    <td>{{ $admin_group->id }}</td>
                                    <td>{{ $admin_group->name }}</td>
                                    <td>{{ $admin_group->category->name }}</td>
                                    <td>
                                        @if (!empty($admin_group->accessed_tabs))
                                            <div class="mt-1 small text-muted">
                                                {{ implode(', ', array_slice($admin_group->accessed_tabs, 0, 5)) }}
                                                {{ count($admin_group->accessed_tabs) > 5 ? '...' : '' }}
                                            </div>
                                        @endif

                                    </td>

                                    <td>
                                        @if ($admin_group->id != 1)
                                            <a href="{{ route('adminGroups.edit', $admin_group->id) }}"
                                                class="btn btn-warning btn-sm me-1 mb-1">Edit</a>
                                            <form action="{{ route('adminGroups.destroy', $admin_group->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm mb-1"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        @endif

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
