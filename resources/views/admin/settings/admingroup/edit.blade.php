@extends('layouts.app')
@section('title', 'Edit Admin Group')
@section('page-title', 'Edit Admin Group')
@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" id="form" action="{{ route('adminGroups.update',$admin_group->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="name" class="form-label">Group Name</label>
                                        <input type="text" id="name"
                                            class="form-control w-100  @error('name')
                                            is-invalid
                                        @enderror"
                                            placeholder="Group Name" name="name" value="{{ old('name',$admin_group->name) }}" />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="admin_group_category_id" class="form-label">Admin Group Category</label>
                                        <select name="admin_group_category_id" id="admin_group_category_id"
                                            class="choices form-select w-100" data-parsley-required="true">
                                            <option value="">Admin Group Category</option>
                                            @foreach ($admin_group_categories as $admin)
                                                <option value="{{ $admin->id }}"
                                                    {{ old('admin_group_category_id',$admin_group->admin_group_category_id) == $admin->id ? 'selected' : '' }}>
                                                    {{ $admin->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 mt-4">
                                    <h6>Accessed Tab</h6>
                                    @foreach ($system_tabs as $tab)
                                        <!-- Parent -->
                                        <div class="form-check form-switch fw-bold mt-2">
                                            <input class="form-check-input parent-tab" type="checkbox"
                                                data-id="{{ $tab->id }}" name="accessed_tabs[]"
                                                value="{{ $tab->slug }}" {{in_array($tab->slug,$admin_group->accessed_tabs)?'checked':''}}>
                                            <label class="form-check-label">
                                                {{ $tab->name }}
                                            </label>
                                        </div>

                                        @foreach ($tab->child as $child)
                                            <div class="form-check form-switch ms-4 mt-1">
                                                <input class="form-check-input child-tab" type="checkbox"
                                                    data-parent="{{ $tab->id }}" name="accessed_tabs[]"
                                                    value="{{ $child->slug }}" {{in_array($child->slug,$admin_group->accessed_tabs)?'checked':''}}>
                                                <label class="form-check-label">
                                                    {{ $child->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <a href="{{ route('adminGroups.index') }}" class="btn btn-secondary mb-1">Cancel</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $('.parent-tab').change(function() {
                let id = $(this).data('id');

                if (!this.checked) {
                    $('.child-tab[data-parent="' + id + '"]')
                        .prop('checked', false)
                        .closest('.form-check')
                        .hide();
                } else {
                    $('.child-tab[data-parent="' + id + '"]')
                        .closest('.form-check')
                        .show();
                }
            });

            $('.child-tab').change(function() {
                if (this.checked) {
                    let pid = $(this).data('parent');
                    $('.parent-tab[data-id="' + pid + '"]')
                        .prop('checked', true)
                        .trigger('change');
                }
            });

            $('.child-tab').each(function() {
                let pid = $(this).data('parent');
                if (!$('.parent-tab[data-id="' + pid + '"]').is(':checked')) {
                    $(this).closest('.form-check').hide();
                }
            });
        });
    </script>
@endsection
