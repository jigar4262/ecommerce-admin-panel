@extends('layouts.app')
@section('title', 'Add Coupon')
@section('page-title', 'Add Coupon')

@section('content')
    <section id="multiple-column-form" class="basic-choices">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
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
                            <form method="POST" class="form" action="{{ route('coupons.store') }}" id="couponForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="coupon_code" class="form-label">Coupon Code</label>
                                            <input type="text" id="coupon_code"
                                                class="form-control w-100 @error('coupon_code') is-invalid @enderror "
                                                placeholder="Coupon Code" name="coupon_code"
                                                value="{{ old('coupon_code') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="discount_type" class="form-label">Discount Type</label>
                                            <select name="discount_type" id="discount_type"
                                                class="choices form-select w-100 @error('discount_type') is-invalid @enderror">
                                                <option value="">Discount Type</option>
                                                <option value="flat"
                                                    {{ old('discount_type') == 'flat' ? 'selected' : '' }}>Flat</option>
                                                <option value="percentage"
                                                    {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="min_order_amt" class="form-label">Minimum Order Amount</label>
                                            <input type="text" id="min_order_amt"
                                                class="form-control w-100 numeric @error('min_order_amt') is-invalid @enderror"
                                                placeholder="Minimum Order Amount" name="min_order_amt"
                                                value="{{ old('min_order_amt') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="discount_value" class="form-label">Discount Value</label>
                                            <input type="text" id="discount_value"
                                                class="form-control w-100 numeric @error('discount_value') is-invalid @enderror"
                                                placeholder="Discount Value" name="discount_value"
                                                value="{{ old('discount_value') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 d-none max_discount">
                                        <div class="form-group mandatory">
                                            <label for="max_discount" class="form-label">Max Discount</label>
                                            <input type="text" id="max_discount"
                                                class="form-control w-100 numeric @error('max_discount') is-invalid @enderror"
                                                placeholder="Max Discount" name="max_discount"
                                                value="{{ old('max_discount') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="start_date" class="form-label">Start Date</label>
                                            <input type="text" id="start_date"
                                                class="form-control flatpickr-basic w-100 @error('start_date') is-invalid @enderror"
                                                placeholder="Start Date" name="start_date"
                                                value="{{ old('start_date') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="end_date" class="form-label">End Date</label>
                                            <input type="text" id="end_date"
                                                class="form-control flatpickr-basic w-100 @error('end_date') is-invalid @enderror"
                                                placeholder="End Date" name="end_date" value="{{ old('end_date') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="apply_coupon_on" class="form-label">Apply Coupon On</label>
                                            <select name="apply_coupon_on" id="apply_coupon_on"
                                                class="choices form-select w-100 @error('apply_coupon_on') is-invalid @enderror">
                                                <option value="">Apply On</option>
                                                <option value="all"
                                                    {{ old('apply_coupon_on') == 'all' ? 'selected' : '' }}>All Products
                                                </option>
                                                <option value="category"
                                                    {{ old('apply_coupon_on') == 'category' ? 'selected' : '' }}>Selected
                                                    Categories</option>
                                                <option value="product"
                                                    {{ old('apply_coupon_on') == 'product' ? 'selected' : '' }}>Selected
                                                    Products</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="is_login_required" class="form-label">Login Required</label>
                                            <select name="is_login_required" id="is_login_required"
                                                class="choices form-select w-100 @error('is_login_required') is-invalid @enderror">
                                                <option value="">Is Logged!</option>
                                                <option value="yes"
                                                    {{ old('is_login_required') == 'yes' ? 'selected' : '' }}>Yes</option>
                                                <option value="no"
                                                    {{ old('is_login_required') == 'no' ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6  d-none col-12" id="product">
                                        <div class="form-group mandatory">
                                            <label for="product_id" class="form-label">Applicable Products</label>
                                            <select name="product_id[]" id="product_id"
                                                class="choices form-select multiple-remove w-100 @error('product_id') is-invalid @enderror"
                                                multiple="multiple">
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ in_array($product->id, old('product_id', [])) ? 'selected' : '' }}>
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 d-none col-12" id="category">
                                        <div class="form-group mandatory">
                                            <label for="category_id" class="form-label">Applicable Categories</label>
                                            <select name="category_id[]" id="category_id"
                                                class="choices form-select multiple-remove w-100 @error('category_id') is-invalid @enderror"
                                                multiple="multiple">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ in_array($category->id, old('category_id', [])) ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="per_user_limit" class="form-label">Per User Limit</label>
                                            <input type="text" id="per_user_limit"
                                                class="form-control w-100 numeric @error('per_user_limit') is-invalid @enderror"
                                                placeholder="Per User Limit" name="per_user_limit"
                                                value="{{ old('per_user_limit') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="total_usage_limit" class="form-label">Total Usage Limit</label>
                                            <input type="text" id="total_usage_limit"
                                                class="form-control w-100 numeric @error('total_usage_limit') is-invalid @enderror"
                                                placeholder="Total Usage Limit" name="total_usage_limit"
                                                value="{{ old('total_usage_limit') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="parent_id" class="form-label">Status</label>
                                            <div
                                                class="form-check form-switch mb-3 @error('status') is-invalid @enderror">
                                                <input class="form-check-input" type="checkbox" id="status"
                                                    name="status" value="1" checked>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="description" class="form-label">Description</label>
                                            <div id="toolbar-location"></div>
                                            <textarea class="form-control" placeholder="Description" id="description" name="description">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <a href="{{ route('coupons.index') }}" class="btn btn-secondary mb-1">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#description',
            height: 300,
            plugins: 'lists link image table code',
            toolbar: 'undo redo | bold italic | bullist numlist | link image | code',
            fixed_toolbar_container: "#toolbar-location"
        });

        $(document).ready(function() {
            let discountType = $('#discount_type').val();
            let applyOn = $('#apply_coupon_on').val();

            if (discountType === "percentage") {
                $('.max_discount').removeClass('d-none');
            } else {
                $('.max_discount').addClass('d-none');
                $('#max_discount').val('');
            }

            $('#category, #product').addClass('d-none');

            if (applyOn === "category") {
                $('#category').removeClass('d-none');
            }

            if (applyOn === "product") {
                $('#product').removeClass('d-none');
            }

            let start_picker = flatpickr("#start_date", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d-m-Y"
            });
            let end_picker = flatpickr("#end_date", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d-m-Y"
            });

            $('#apply_coupon_on').on('change', function() {

                let apply = $(this).val();

                $('#category, #product').addClass('d-none');
              
                if (apply === "category") {
                    $('#category').removeClass('d-none');
                }

                if (apply === "product") {
                    $('#product').removeClass('d-none');
                }

            });

            $('#discount_type').on('change', function() {
                let type = $(this).val();
                if (type === "percentage") {
                    $('.max_discount').removeClass('d-none');
                    // $('#max_discount').attr('data-parsley-required', 'true');
                } else {
                    $('.max_discount').addClass('d-none');
                    $('#max_discount').val('');
                    // $('#max_discount').removeAttr('data-parsley-required').val('');
                }
                validateFlatDiscount();
            });

            $('#coupon_code').on('input', function() {
                this.value = this.value.toUpperCase();
            });

            function validateFlatDiscount() {
                let type = $('#discount_type').val();
                let discount = parseFloat($('#discount_value').val());
                let minOrder = parseFloat($('#min_order_amt').val());
                let maxDiscount = parseFloat($('#max_discount').val());

                if (type === "flat" && discount && minOrder && discount > minOrder) {
                    Swal.fire({
                        icon: "warning",
                        title: "Invalid Discount",
                        text: "Flat discount cannot be greater than Minimum Order Amount .",
                        confirmButtonColor: "#3085d6"
                    });
                    $('#discount_value').val('');
                }

                if (type === "percentage" && discount) {
                    if (discount < 1 || discount > 100) {
                        Swal.fire({
                            icon: "warning",
                            title: "Invalid Percentage",
                            text: "Percentage discount must be between 1 - 100 .",
                            confirmButtonColor: "#3085d6"
                        });
                        $('#discount_value').val('');
                    }
                    if (maxDiscount && maxDiscount < 0) {
                        $('#max_discount').val('');
                    }
                }
            }

            $('#discount_value, #min_order_amt, #max_discount').on('input', validateFlatDiscount);

            $('#end_date').on('change', function() {
                let start = new Date($('#start_date').val());
                let end = new Date($('#end_date').val());
                if (start && end && start > end) {
                    Swal.fire({
                        icon: "warning",
                        title: " Invalid Date",
                        text: "End date must be greater than Start date .",
                        confirmButtonColor: "#3085d6"
                    });
                    $(this).val('');
                }
            });

            $('#couponForm').on('submit', function(e) {
                validateFlatDiscount();

                let start = new Date($('#start_date').val());
                let end = new Date($('#end_date').val());
                if (start && end && start > end) {
                    Swal.fire({
                        icon: "warning",
                        title: " Invalid Date",
                        text: "End date must be greater than Start date .",
                        confirmButtonColor: "#3085d6"
                    });
                    $('#end_date').val('');
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
