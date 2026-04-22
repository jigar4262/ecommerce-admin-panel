@extends('layouts.app')
@section('title', 'Edit Options')
@section('page-title', 'Edit Options')
@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" id="option_form" class="form" enctype="multipart/form-data"
                                action="{{ route('options.update', $option->id) }}">
                                @csrf
                                @method('PUT')

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="option_name" class="form-label">Option Name</label>
                                            <input type="text" id="option_name" name="option_name"
                                                class="form-control @error('option_name') is-invalid @enderror"
                                                placeholder="Option Name"
                                                value="{{ old('option_name', $option->option_name) }}">
                                            @error('option_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        {{-- FIX #4: @error moved INSIDE the form-group div, after the select --}}
                                        <div class="form-group mandatory">
                                            <label for="option_type_id" class="form-label">Option Type</label>
                                            <select name="option_type_id" id="option_type_id"
                                                class="choices form-select @error('option_type_id') is-invalid @enderror">
                                                <option value="">-- Option Type --</option>
                                                <option value="select"
                                                    {{ old('option_type_id', $option->option_type_id) == 'select' ? 'selected' : '' }}>
                                                    Select</option>
                                                <option value="radio"
                                                    {{ old('option_type_id', $option->option_type_id) == 'radio' ? 'selected' : '' }}>
                                                    Radio</option>
                                                <option value="checkbox"
                                                    {{ old('option_type_id', $option->option_type_id) == 'checkbox' ? 'selected' : '' }}>
                                                    Checkbox</option>
                                                <option value="text"
                                                    {{ old('option_type_id', $option->option_type_id) == 'text' ? 'selected' : '' }}>
                                                    Text</option>
                                                <option value="textarea"
                                                    {{ old('option_type_id', $option->option_type_id) == 'textarea' ? 'selected' : '' }}>
                                                    Textarea</option>
                                                <option value="file"
                                                    {{ old('option_type_id', $option->option_type_id) == 'file' ? 'selected' : '' }}>
                                                    File</option>
                                                <option value="date"
                                                    {{ old('option_type_id', $option->option_type_id) == 'date' ? 'selected' : '' }}>
                                                    Date</option>
                                            </select>
                                            @error('option_type_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div id="optionvalueselection" style="display:none;" class="table-responsive mt-3">
                                    <table class="table" id="option_tb">
                                        <thead>
                                            <tr>
                                                <th>Value Name</th>
                                                <th>Image</th>
                                                <th>Sort Order</th>
                                                <th style="width:100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @php
                                                $values = old(
                                                    'option_values',
                                                    $option->values
                                                        ->map(
                                                            fn($v) => [
                                                                'id' => $v->id,
                                                                'value' => $v->value_name,
                                                                'sort_order' => $v->sort_order,
                                                                'image' => $v->image,
                                                            ],
                                                        )
                                                        ->toArray(),
                                                );
                                            @endphp

                                            @foreach ($values as $key => $value)
                                                <tr>
                                                    <td>

                                                        <input type="hidden" name="option_values[{{ $key }}][id]"
                                                            value="{{ $value['id'] ?? '' }}">
                                                        <input type="text"
                                                            name="option_values[{{ $key }}][value]"
                                                            class="form-control value-input @error('option_values.' . $key . '.value') is-invalid @enderror"
                                                            value="{{ $value['value'] ?? '' }}">
                                                        @error('option_values.' . $key . '.value')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>

                                                        @if (!empty($value['image']) && !is_object($value['image']))
                                                            <img src="{{ asset('uploads/' . $value['image']) }}"
                                                                width="50">
                                                        @endif
                                                        <input type="file"
                                                            name="option_values[{{ $key }}][image]"
                                                            class="form-control value-img @error('option_values.' . $key . '.image') is-invalid @enderror">
                                                        @error('option_values.' . $key . '.image')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="option_values[{{ $key }}][sort_order]"
                                                            class="form-control sort-input numeric @error('option_values.' . $key . '.sort_order') is-invalid @enderror"
                                                            value="{{ $value['sort_order'] ?? '' }}">
                                                        @error('option_values.' . $key . '.sort_order')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-success btn-sm addrow">+</button>
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm removerow">-</button>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1">Submit</button>
                                        <a href="{{ route('options.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {

            const select = document.getElementById('option_type_id');

            if (!select.hasAttribute('data-choices-initialized')) {
                new Choices(select, {
                    searchEnabled: false,
                    itemSelectText: '',
                    allowHTML: true
                });
                select.setAttribute('data-choices-initialized', 'true');
            }

            
            let index = {{ count($values) }};

          
            let currentType = '{{ old('option_type_id', $option->option_type_id) }}';
            if (['select', 'radio', 'checkbox'].includes(currentType)) {
                $('#optionvalueselection').show();
            } else {
                $('#optionvalueselection').hide();
            }

    
            $('#option_type_id').change(function() {
                let type = $(this).val();

                $('#option_tb tbody').html(`<tr>
                    <td>
                        <input type="hidden" name="option_values[0][id]" value="">

                        <input type="text" name="option_values[0][value]" class="form-control value-input"></td>
                    <td><input type="file" name="option_values[0][image]" class="form-control value-img"></td>
                    <td><input type="text" name="option_values[0][sort_order]" class="form-control sort-input numeric"></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-success btn-sm addrow">+</button>
                        <button type="button" class="btn btn-danger btn-sm removerow">-</button>
                    </td>
                </tr>`);

                if (['select', 'radio', 'checkbox'].includes(type)) {
                    $('#optionvalueselection').show();
                } else {
                    $('#optionvalueselection').hide();
                }
            });


            $(document).on('click', '.addrow', function() {
                var newrow = `<tr>
                    
                    <td>
                        <input type="hidden" name="option_values[${index}][id]" value="">
                        <input type="text" name="option_values[${index}][value]" class="form-control value-input"></td>
                    <td><input type="file" name="option_values[${index}][image]" class="form-control value-img"></td>
                    <td><input type="text" name="option_values[${index}][sort_order]" class="form-control sort-input numeric"></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-success btn-sm addrow">+</button>
                        <button type="button" class="btn btn-danger btn-sm removerow">-</button>
                    </td>
                </tr>`;
                $(this).closest('tr').after(newrow);

                $(this).closest('tr').next().find('.value-input').focus();
         
                index++;
            });

            $(document).on('click', '.removerow', function() {
                let rowCount = $('#option_tb tbody tr').length;
                if (rowCount === 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'At least one option value is required.'
                    });
                    return;
                }
                $(this).closest('tr').remove();
            });
        });
    </script>
@endsection
