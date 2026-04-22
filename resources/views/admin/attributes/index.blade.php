@extends('layouts.app')

@section('title', 'Attributes')
@section('page-title', 'Attributes')

@section('content')
    <section class="section">
        <div class="card">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Attribute Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attributes as $attribute )
                                <tr>
                                    <td>{{$attribute->id}}</td>
                                    <td>{{$attribute->name}}</td>
                                    <td>
                                        @if ($attribute->status)
                                            <span class="badge bg-success">Active</span>
                                            @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('attributes.edit',$attribute->id)}}" class="btn btn-warning btn-sm me-1 mb-1">Edit</a>

                                        <form action="{{route('attributes.destroy',$attribute->id)}}" method="POST" style="display:inline;">
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
