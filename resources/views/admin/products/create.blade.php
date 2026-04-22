@extends('layouts.app')
@section('title', 'Add Product')
@section('page-title', 'Add Product')
@section('content')
    <section id="multiple-column-form" class="basic-choices">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            {{-- @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}
                            <ul class="nav nav-tabs" id="product_tab" role="tablist">
                                <li class="nav-item">
                                    <a href="#general" class="nav-link active" role="tab"
                                        data-bs-toggle="tab">Genral</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#images" class="nav-link " role="tab" data-bs-toggle="tab">Images</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#discount" class="nav-link " role="tab" data-bs-toggle="tab">Discount</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#attributes" class="nav-link " role="tab"
                                        data-bs-toggle="tab">Attributes</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#options" class="nav-link " role="tab" data-bs-toggle="tab">Options</a>
                                </li>
                            </ul>
                            <form method="POST" class="form" action="{{ route('products.store') }}"
                                enctype="multipart/form-data" id="product_form">
                                @csrf
                                <div class="tab-content pt-3">
                                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="">
                                                    <label for="name" class="form-label">Product Name </label>
                                                    <input type="text" id="name" class="form-control w-100"
                                                        placeholder="Product Name" name="name" data-errors-key="name" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mandatory">
                                                    <label for="sku" class="form-label">SKU</label>
                                                    <input type="text" id="sku" class="form-control w-100"
                                                        placeholder="SKU" name="sku" data-errors-key="sku" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mandatory">
                                                    <label for="slug" class="form-label">Slug</label>
                                                    <input type="text" id="slug" class="form-control w-100"
                                                        placeholder="Slug" name="slug" data-errors-key="slug" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mandatory">
                                                    <label for="stock_qty" class="form-label">Stock Qty</label>
                                                    <input type="text" id="stock_qty" class="form-control w-100 numeric"
                                                        placeholder="Stock Qty" name="stock_qty" placeholder="0.00"
                                                        step="0.01" min="0" data-errors-key="stock_qty" />
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group mandatory">
                                                    <label for="max_qty" class="form-label">Maximum Order Qty</label>
                                                    <input type="text" id="max_qty" class="form-control w-100 numeric"
                                                        placeholder="Maximum Order Qty" name="max_qty" min="1"
                                                        data-errors-key="max_qty" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mandatory">
                                                    <label for="min_qty" class="form-label">Minimum Order Qty</label>
                                                    <input type="text" id="min_qty"
                                                        class="form-control w-100 numeric" placeholder="Minimum Order Qty"
                                                        name="min_qty" min="1" data-errors-key="min_qty" />
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea class="form-control" placeholder="Description" id="description" name="description"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="">
                                                    <label for="category_id" class="form-label">Categories</label>
                                                    <select name="category_id[]" id="category_id"
                                                        class="choices form-select multiple-remove w-100"
                                                        multiple="multiple" data-errors-key="category_id">

                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mandatory">
                                                    <label for="price" class="form-label">Price</label>
                                                    <input type="text" id="price"
                                                        class="form-control w-100 numeric" placeholder="Price"
                                                        name="price" min="0" step="0.01"
                                                        data-errors-key="price" />
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- image -->
                                    <div class="tab-pane fade" id="images" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12 col-md-12">
                                                <div class="form-group mandatory">
                                                    <label for="main_image" class="form-label">Main Image</label>
                                                    <input type="file" class="basic-filepond" id="main_image"
                                                        name="main_image" data-errors-key="main_image">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <div class="form-group ">
                                                    <label for="multipule_image" class="form-label">Multiple Image</label>
                                                    <input type="file" class="multiple-files-filepond "
                                                        id="multipule_image" name="multiple_image[]" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="discount" role="tabpanel">
                                        <table class="table table-bordered table-responsive table-striped"
                                            id="discount_table">
                                            <thead>
                                                <tr>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Sort Order</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="discount-row" data-index="0">
                                                    <td><input type="text" name="discount_qty[]"
                                                            class="form-control numeric" min="0.00" step="0.01">
                                                    </td>
                                                    <td>
                                                        <div class="currency-price-wrapper d-flex flex-column gap-2">
                                                            <div
                                                                class="currency-price-row d-flex gap-2 align-items-center">
                                                                <select name="discount_currency[0][]"
                                                                    class="form-select discount_currency flex-grow-1">
                                                                    <option value="">-- Currency --</option>
                                                                    <option value="USD">USD</option>
                                                                    <option value="GBP">GBP</option>
                                                                    <option value="CAD">CAD</option>
                                                                    <option value="AUD">AUD</option>
                                                                    <option value="NZD">NZD</option>
                                                                    <option value="EUR">EUR</option>
                                                                </select>
                                                                <input type="text" name="discount_price[0][]"
                                                                    class="form-control flex-grow-1 numeric"
                                                                    min="0.00">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm remove-price-row">
                                                                    <i class="bi bi-dash"></i>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-primary btn-sm add-price-row">
                                                                    <i class="bi bi-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><input type="text" name="discount_sort[]"
                                                            class="form-control numeric"></td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-discount-row">
                                                            <i class="bi bi-dash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" class="text-end">
                                                        <button type="button" id="add_discount_row"
                                                            class="btn btn-primary">
                                                            <i class="bi bi-plus"></i> Add Discount
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="tab-pane fade" id="attributes" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="attribute_id" class="form-label">Attributes</label>
                                                    <select id="attribute_id" class="choices form-select w-100">
                                                        <option value="">Attribute</option>
                                                        @foreach ($attributes as $attribute)
                                                            <option value="{{ $attribute->id }}">{{ $attribute->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table" id="attribute_tb">
                                            <thead>
                                                <tr>
                                                    <th>Attribute Name</th>
                                                    <th>Value</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>


                                    <div class="tab-pane fade" id="options" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label">Select Option:</label>
                                            <select id="option_select" class="form-select w-50">
                                                <option value="">-- Select Option --</option>
                                                @foreach ($options as $option)
                                                    <option value="{{ $option->id }}"
                                                        data-type="{{ $option->option_type_id }}">
                                                        {{ $option->option_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <hr>

                                        <div class="row mt-2">
                                            <div class="col-md-3">
                                                <div id="optionTabs" class="nav flex-column nav-pills"></div>
                                            </div>
                                            <div class="col-md-9">
                                                <div id="optionTabContent" class="tab-content"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <a href="{{ route('products.index') }}" class="btn btn-secondary mb-1">Cancel</a>
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
            $(document).on('submit', '#product_form', function(e) {
                e.preventDefault();

                let form = $(this);
                let form_data = new FormData(this);

                $.ajax({
                    url: '{{ route('products.store') }}',
                    method: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: res.message,
                            confirmButtonColor: "#3085d6"
                        }).then(() => {
                            window.location.href = "{{ route('products.index') }}";
                        })
                    },
                    error: function(res) {
                        if (res.status === 422) {
                            let errors = res.responseJSON.errors;
                            showErr(errors);
                        }
                    }
                });
            });
            let a_index = 0;
            $('#attribute_id').on('change', function() {
                let attribute_id = $(this).val();
                let name = $(this).find('option:selected').text();

                if (!attribute_id) return;

                if ($(`input[name='attribute_id[]'][value='${attribute_id}']`).length > 0) {
                    Swal.fire({
                        icon: "warning",
                        title: "Already Added!",
                        text: "This attribute is already in the list.",
                        confirmButtonColor: "#3085d6"
                    });
                    $(this).val("");
                    return;
                }

                $('#attribute_tb tbody').append(`
            <tr>

              <td><input type="hidden" name="attribute_id[]" value="${attribute_id}">${name}</td>
              <td>
                <input type="text" name="attribute_value[]" class="form-control" data-errors-key="attribute_value.${a_index}">
                </td>

                <td>
                    <button class="btn btn-danger btn-sm remove-row">-</button>
                    </td>
            </tr>
            `);
                a_index++;
                $(this).val('');
            });

            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
                $(this).val("");
            });


            // discount//

            let d_index = 1;

            $('#add_discount_row').click(function() {
                $('#discount_table tbody').append(`
                                                 <tr class="discount-row" data-index="${d_index}">
                                                    <td><input type="text" name="discount_qty[]"
                                                            class="form-control numeric" min="0.00" step="0.01">
                                                    </td>
                                                    <td>
                                                        <div class="currency-price-wrapper d-flex flex-column gap-2">
                                                            <div
                                                                class="currency-price-row d-flex gap-2 align-items-center">
                                                                <select name="discount_currency[${d_index}][]"
                                                                    class="form-select discount_currency flex-grow-1">
                                                                    <option value="">-- Currency --</option>
                                                                    <option value="USD">USD</option>
                                                                    <option value="GBP">GBP</option>
                                                                    <option value="CAD">CAD</option>
                                                                    <option value="AUD">AUD</option>
                                                                    <option value="NZD">NZD</option>
                                                                    <option value="EUR">EUR</option>
                                                                </select>
                                                                <input type="text" name="discount_price[${d_index}][]"
                                                                    class="form-control flex-grow-1 numeric"
                                                                    min="0.00">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm remove-price-row">
                                                                    <i class="bi bi-dash"></i>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-primary btn-sm add-price-row">
                                                                    <i class="bi bi-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><input type="text" name="discount_sort[]"
                                                            class="form-control numeric"></td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-discount-row">
                                                            <i class="bi bi-dash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
              `);

                d_index++;
            });

            $(document).on('click', '.remove-discount-row', function() {
                if ($('#discount_table tbody tr').length > 1) {
                    $(this).closest('tr').remove();
                }
            });

            $(document).on('click', '.add-price-row', function() {
                let row = $(this).closest('.discount-row');
                let newPriceRow = $(this).closest('.currency-price-row').clone();
                newPriceRow.find('select').val('');
                newPriceRow.find('input').val('');
                let rowIndex = row.data('index');
                newPriceRow.find('select').attr('name', `discount_currency[${rowIndex}][]`);
                newPriceRow.find('input').attr('name', `discount_price[${rowIndex}][]`);

                row.find('.currency-price-wrapper').append(newPriceRow);
            });

        
            $(document).on('click', '.remove-price-row', function() {
                let wrapper = $(this).closest('.currency-price-wrapper');
                if (wrapper.find('.currency-price-row').length > 1) {
                    $(this).closest('.currency-price-row').remove();
                }
            });

        
            $(document).on('change', '.discount_currency', function() {

                let currentSelect = $(this);
                let row = currentSelect.closest('.discount-row');
                let selectedValue = currentSelect.val();
                let duplicate = false;

                row.find('.discount_currency').each(function() {
                    if ($(this).is(currentSelect)) return;
                    if ($(this).val() === selectedValue) duplicate = true;
                });

                if (duplicate) {
                    Swal.fire("Duplicate Currency", "Currency already selected in this row!", "error");

                    currentSelect.val('');
                }
            });

            $(document).on('input change', '#discount_table input, #discount_table select', function() {
                let used = false;

                $('#discount_table input, #discount_table select').each(function() {
                    if ($(this).val().trim() !== '') {
                        used = true;
                        return false;
                    }
                });

                if (used) {
                    $('#discount_table input, #discount_table select').prop('required', true);
                } else {
                    $('#discount_table input, #discount_table select').prop('required', false);
                }
            });

            ///option///

            $('#option_select').change(function() {

                let id = $(this).val();
                let name = $(this).find('option:selected').text();
                let type = $(this).find('option:selected').data('type');

                if (!id) return;

                if ($("#tab-btn-" + id).length) {
                    $("#tab-btn-" + id).click();
                    $(this).val("");
                    return;
                }

                $('#optionTabs').append(`
                         <button type="button" class="nav-link mb-1" id="tab-btn-${id}" data-bs-toggle="pill" data-bs-target="#tab-${id}">
                                 ${name}
                            <span class="badge bg-danger ms-2 remove_option" data-id="${id}">X</span>
                        </button>
                      `);

                $('#optionTabContent').append(`
                             <div class="tab-pane fade" id="tab-${id}" data-option-id="${id}"></div>
                  `);

                $.post("{{ route('admin.load.option') }}", {
                    option_id: id,
                    type: type,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function(html) {

                    $('#tab-' + id).html(html);
                    $("#tab-btn-" + id).click();
                });
                $(this).val('');
            });

            $(document).on("click", ".remove_option", function(e) {
                e.stopPropagation();
                let id = $(this).data("id");

          
                let isActive = $("#tab-btn-" + id).hasClass("active");

                $("#tab-btn-" + id).remove();
                $("#tab-" + id).remove();

                
                if (isActive) {
                    let firstTab = $("#optionTabs .nav-link:first");
                    if (firstTab.length) {
                        firstTab.click();
                    }
                }
            });

         
            $(document).on('click', '.add_value', function() {

                let container = $(this).closest('.value_container');
                let card = $(this).closest('.value_card');

                let clone = card.clone();

                clone.find('input').val('');
                clone.find('select').val('');
                clone.find('.is-invalid').removeClass('is-invalid');
                clone.find('.value_enable_check').prop('checked', true);

                clone.find('.image_block:not(:first)').remove();
                clone.find('.image_block input').val('');

                clone.find('.price_block:not(:first)').remove();
                clone.find('.price_block input').val('');
                clone.find('.price_block select').val('');
                container.append(clone);
                updateValueIndex(container);
            });

            $(document).on('click', '.remove_value', function() {
                let container = $(this).closest('.value_container');
                if (container.find('.value_card').length > 1) {
                    $(this).closest('.value_card').remove();
                    updateValueIndex(container);
                }

            });
e

            $(document).on('click', '.add_price', function() {

                let block = $(this).closest('.price_block');
                let clone = block.clone();

                clone.find('input').val('');
                clone.find('select').val('');
                block.after(clone);
            });

            $(document).on('click', '.remove_price', function() {
                let area = $(this).closest('.price_area');

                if (area.find('.price_block').length > 1) {
                    $(this).closest('.price_block').remove();
                }
            });

            $(document).on('change', '.price_block select', function() {

                let current = $(this);
                let selected = current.val();

                let area = current.closest('.price_area');

                let count = 0;

                area.find('select').each(function() {
                    if ($(this).val() === selected) {
                        count++;
                    }
                });

                if (count > 1) {
                    Swal.fire("Duplicate", "Currency already added!", "error");
                    current.val('');
                }
            });

   
            $(document).on('click', '.add_image', function() {

                let block = $(this).closest('.image_block');

                let newBlock = block.clone();

             
                newBlock.find('input[type="file"]').val('');

                block.after(newBlock);
            });

            $(document).on('click', '.remove_image', function() {

                let container = $(this).closest('.image_area');

                if (container.find('.image_block').length > 1) {
                    $(this).closest('.image_block').remove();
                }
            });

            $(document).on('change', '.value_select', function() {

                let current = $(this);
                let selectedVal = current.val();

                let container = current.closest('.value_container');
                let isDuplicate = false;

                container.find('.value_select').each(function() {

                    if ($(this).is(current)) return;

                    if ($(this).val() == selectedVal && selectedVal != '') {
                        isDuplicate = true;
                    }
                });

                if (isDuplicate) {
                    Swal.fire({
                        icon: "error",
                        title: "Duplicate Value",
                        text: "This value is already selected!",
                        confirmButtonColor: "#3085d6"
                    });

                    current.val('').trigger('change'); 
                }
            });
        });

        function updateValueIndex(container) {

            let optionId = container.closest('.tab-pane').data('option-id');

            container.find('.value_card').each(function(index) {

                $(this).find('.value_select')
                    .attr('name', `value_id[${optionId}][${index}][]`).data('errors-key',
                        `value_id.${optionId}.${index}.0`);

                $(this).find('.price_operator')
                    .attr('name', `price_operator[${optionId}][${index}][]`);

                $(this).find('.value_enable_check')
                    .attr('name', `is_enabled[${optionId}][${index}][]`);

                $(this).find('.img_input')
                    .attr('name', `value_images[${optionId}][${index}][]`);

                $(this).find('.price_block select')
                    .attr('name', `options_currency[${optionId}][${index}][]`);

                $(this).find('.price_block input')
                    .attr('name', `options_price[${optionId}][${index}][]`);

            });
        }

        function showErr(errors) {

            console.log(errors);
            $('.error-box').remove();
            $('.is-invalid').removeClass('is-invalid');

            let errorHtml = '<div class="alert alert-danger error-box"><ul>';

            $.each(errors, function(key, msg) {

                errorHtml += '<li>' + msg + '</li>';


                let field = $('[data-errors-key="' + key + '"]');

                if (field.length) {
                    field.addClass('is-invalid');
                }

            });

            errorHtml += '</ul></div>';
            $('.card-body').prepend(errorHtml);
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#description',
            height: 300,
            plugins: 'lists link image table code',
            toolbar: 'undo redo | bold italic | bullist numlist | link image | code'
        });
    </script>

@endsection
