@extends('layouts.app')

@section('title', 'Admin Group Category')
@section('page-title', 'Admin Group Category')

@section('content')
    <section class="section">
        <div class="card">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($admin_group_categories as $admin_category )
                                <tr>
                                    <td>{{$admin_category->id}}</td>
                                    <td>{{$admin_category->name}}</td>
                                    <td>
                                        <a href="{{route('adminGroupCategories.edit',$admin_category->id)}}" class="btn btn-warning btn-sm me-1 mb-1">Edit</a>
                                        <form action="{{route('adminGroupCategories.destroy',$admin_category->id)}}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No Data Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
