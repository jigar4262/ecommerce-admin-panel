@extends('layouts.app')
@section('title', 'Add Admin User')
@section('page-title', 'Add Admin User')
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
                        <form method="POST" id="form" action="{{ route('admins.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" id="first_name"
                                            class="form-control w-100  @error('first_name')
                                            is-invalid
                                        @enderror"
                                            placeholder="First Name" name="first_name" value="{{ old('first_name') }}" />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" id="last_name"
                                            class="form-control w-100  @error('last_name')
                                            is-invalid
                                        @enderror"
                                            placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="username" class="form-label">User Name</label>
                                        <input type="text" id="username"
                                            class="form-control w-100  @error('username')
                                            is-invalid
                                        @enderror"
                                            placeholder="User Name" name="username" value="{{ old('username') }}" />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" id="email"
                                            class="form-control w-100  @error('email')
                                            is-invalid
                                        @enderror"
                                            placeholder="Email" name="email" value="{{ old('email') }}" />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" id="password"
                                            class="form-control w-100  @error('password')
                                            is-invalid
                                        @enderror"
                                            placeholder="Password" name="password" value="{{ old('password') }}" />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="admin_group_id" class="form-label">Admin Group</label>
                                        <select name="admin_group_id" id="admin_group_id"
                                            class="choices form-select w-100" >
                                            <option value="">Admin Group</option>
                                            @foreach ($admin_groups as $admin_group)
                                                <option value="{{ $admin_group->id }}"
                                                    {{ old('admin_group_id') == $admin_group->id ? 'selected' : '' }}>
                                                    {{ $admin_group->name }}</option>
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
                                                value="{{ $tab->slug }}">
                                            <label class="form-check-label">
                                                {{ $tab->name }}
                                            </label>
                                        </div>

                                        @foreach ($tab->child as $child)
                                            <div class="form-check form-switch ms-4 mt-1">
                                                <input class="form-check-input child-tab" type="checkbox"
                                                    data-parent="{{ $tab->id }}" name="accessed_tabs[]"
                                                    value="{{ $child->slug }}">
                                                <label class="form-check-label">
                                                    {{ $child->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                        <!-- Child -->
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <a href="{{ route('admins.index') }}" class="btn btn-secondary mb-1">Cancel</a>
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

        $('#admin_group_id').change(function(){
          let admin_group_id=$(this).val();
          $('.parent-tab,.child-tab').prop('checked', false).trigger('change');

          $.ajax({
           url:'{{route('admins.adminGroup')}}',
           method:'POST',
           data:{
             _token: "{{ csrf_token() }}",
            admin_group_id: admin_group_id
           },
           success:function(res){
             res.forEach(slug => {
                $('input[value="'+slug+'"]').prop('checked',true).trigger('change');
             });
           }
          });
        });
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
