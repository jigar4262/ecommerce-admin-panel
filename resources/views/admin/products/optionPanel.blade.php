@if ($has_values)
    <div class="value_container">
        <div class="value_card card border border-primary p-3 mb-3" data-card-index="0">
            <div class="d-flex justify-content-between mb-3">
                <h6>{{ $option->option_name }}</h6>
                <div>
                    <button type="button" class="btn btn-sm btn-success add_value">+</button>
                    <button type="button" class="btn btn-sm btn-danger remove_value">-</button>
                </div>
            </div>
            <div class="mb-3">
                <label>Select Value</label>
                <select name="value_id[{{ $option->id }}][0][]" class="form-select value_select" data-errors-key="value_id.{{$option->id}}.0.0" >
                    <option value="">-- Select --</option>
                    @foreach ($option->values as $v)
                        <option value="{{ $v->id }}">{{ $v->value_name }}</option>
                    @endforeach
                </select>
            </div>
  
            <div class="mb-3">
                <label>Price Operator</label>
                <select name="price_operator[{{ $option->id }}][0][]" class="form-select price_operator">
                    <option value="">-- Operator --</option>
                    <option value="+">+ Add</option>
                    <option value="-">- Subtract</option>
                    <option value="=">= Fixed</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Enable</label>
                <div class="form-check form-switch">
                    <input class="form-check-input value_enable_check" type="checkbox" role="switch"
                        name="is_enabled[{{ $option->id }}][0][]" value="1" checked>
                </div>
            </div>

            <div class="image_area mb-3">
                <label>Images</label>
                <div class="image_block p-2 border rounded mb-3 me-1">
                    <input type="file" class="form-control img_input" name="value_images[{{ $option->id }}][0][]"
                        multiple>
                    <button type="button" class=" mt-2 btn btn-sm btn-success add_image">+</button>
                    <button type="button" class=" mt-2 btn btn-sm btn-danger remove_image">-</button>
                </div>
            </div>


            <div class="price_area">
                <label>Price</label>
                <div class="price_block d-flex gap-2 mb-2">
                    <select class="form-select" name="options_currency[{{ $option->id }}][0][]">
                        <option value="">-- currency --</option>
                        <option value="INR">INR</option>
                        <option value="USD">USD</option>
                    </select>

                    <input type="number" class="form-control" name="options_price[{{ $option->id }}][0][]">

                    <button type="button" class="btn btn-sm btn-success add_price">+</button>
                    <button type="button" class="btn btn-sm btn-danger remove_price">-</button>
                </div>
            </div>

        </div>
    </div>
@else
    <div class="card p-3">
        <div class="alert alert-warning">Customer will fill this</div>

        <h6>{{ $option->option_name }}</h6>

        @if ($option->option_type_id == 'text')
            <input type="text" class="form-control" disabled>
        @endif

        @if ($option->option_type_id == 'textarea')
            <textarea class="form-control" disabled></textarea>
        @endif

        @if ($option->option_type_id == 'date')
            <input type="date" class="form-control" disabled>
        @endif

        @if ($option->option_type_id == 'file')
            <input type="file" class="form-control" disabled>
        @endif

        <input type="hidden" name="customer_input_options[]" value="{{ $option->id }}">
    </div>

@endif
