@extends('layouts.app')

@section('title', 'Admin Group Category')
@section('page-title', 'Create Admin Group Category')

@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">

                            <form method="POST" action="{{ route('adminGroupCategories.store') }}" class="form">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 col-12">

                                        <label class="form-label">Name</label>

                                        <input type="text" name="name" value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Name">

                                        {{-- error message --}}
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <a href="{{ route('adminGroupCategories.index') }}" class="btn btn-secondary mb-1">Cancel</a>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
