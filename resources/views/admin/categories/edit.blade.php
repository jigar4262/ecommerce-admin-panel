@extends('layouts.app')

@section('title', 'Categories')
@section('page-title', 'Edit Category')

@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" class="form" id="category_form"
                                action="{{ route('categories.update', $category->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <label for="name" class="form-label">Category Name</label>
                                        <input type="text" id="name"
                                            class="form-control w-100 @error('name') is-invalid @enderror"
                                            placeholder="Category Name" name="name"
                                            value="{{ old('name', $category->name) }}" />
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <label for="parent_category" class="form-label">Parent Category</label>
                                        <select name="parent_id" id="parent_id" class="choices form-select w-100">
                                            <option value="">-- No Parent --</option>
                                            @foreach ($categories ?? [] as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ $category->parent_id == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="choices form-select w-100">
                                            <option value="1" {{ $category->status ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ !$category->status ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>
                                        <a href="{{ route('categories.index') }}" class="btn btn-secondary mb-1">Cancel</a>
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
