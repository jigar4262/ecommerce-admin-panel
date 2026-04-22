@extends('layouts.app')
@section('title', 'Categories')
@section('page-title', 'Categories')
@section('content')
    <section class="section">
        <div class="card">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Parent</th>
                                <th>Category Slug</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $cat)
                        
                                <tr>
                                    <td>{{ $cat->id }}</td>
                                    <td>{{ $cat->name }}</td>
                                    <td>{{ $cat->parent->name??'-' }}</td>
                                    <td>{{ $cat->slug }}</td>
                                    <td>
                                             @if ($cat->status)
                                            <span class="badge bg-success">Active</span>
                                            @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                        
                                    </td>
                                    <td>
                                        <a href="{{ route('categories.edit', $cat->id) }}"
                                            class="btn btn-warning btn-sm me-1 mb-1">Edit</a>
                                        <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mb-1"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
