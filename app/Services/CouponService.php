<?php

namespace App\Services;

use App\Models\Coupon;
use App\Repositories\CouponRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CouponService
{
    protected $coupon_repo;

    public function __construct(CouponRepository $repo)
    {
        $this->coupon_repo = $repo;
    }

    public function create($data)
    {
        // dd($data);
        $validator = Validator::make($data, [
            'coupon_code' => 'required|min:3|unique:coupons,coupon_code',
            'discount_type' => 'required|in:flat,percentage',
            'min_order_amt' => 'required|numeric|min:0',
            'discount_value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|required_if:discount_type,percentage|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'apply_coupon_on' => 'required|in:all,category,product',
            'product_id' => 'nullable|required_if:apply_coupon_on,product|array',
            'category_id' => 'nullable|required_if:apply_coupon_on,category|array',
            'per_user_limit' => 'required|integer|min:1',
            'total_usage_limit' => 'required|integer|min:1',
            'status' => 'nullable|boolean',
            'is_login_required' => 'required|in:yes,no',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        DB::transaction(function () use ($data) {
            $data['created_by'] = session('admin_id');
            $data['status'] = isset($data['status']) ? 1 : 0;
            $data['coupon_code'] = strtoupper($data['coupon_code']);
            // dd($data);
            $coupon = $this->coupon_repo->create($data);

            if (!empty($data['category_id'])) {
                $coupon->categories()->attach($data['category_id']);
            }

            if (!empty($data['product_id'])) {
                $coupon->products()->attach($data['product_id']);
            }
        });
    }

    public function get_all()
    {
        return $this->coupon_repo->get_all();
    }

    public function delete($id)
    {
        $coupon = $this->coupon_repo->find($id);
        return $this->coupon_repo->delete($coupon);
    }

    public function update($id, $data)
    {
        $coupon = $this->coupon_repo->find($id);

        $validator = Validator::make($data, [
            'coupon_code' => ['required', Rule::unique('coupons', 'coupon_code')->ignore($coupon->id)],
            'discount_type' => 'required|in:flat,percentage',
            'min_order_amt' => 'required|numeric|min:0',
            'discount_value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|required_if:discount_type,percentage|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'apply_coupon_on' => 'required|in:all,category,product',
            'product_id' => 'nullable|required_if:apply_coupon_on,product|array',
            'category_id' => 'nullable|required_if:apply_coupon_on,category|array',
            'per_user_limit' => 'required|integer|min:1',
            'total_usage_limit' => 'required|integer|min:1',
            'status' => 'nullable|boolean',
            'is_login_required' => 'required|in:yes,no',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        DB::transaction(function () use ($coupon, $data) {
            $data['updated_by'] = session('admin_id');
            $data['status'] = isset($data['status']) ? 1 : 0;
            $data['coupon_code'] = strtoupper($data['coupon_code']);
            if ($data['apply_coupon_on'] == 'all') {
                $data['category_id'] = null;
                $data['product_id'] = null;
            } else if ($data['apply_coupon_on'] == 'category') {
                $data['product_id'] = null;
            } else {
                $data['category_id'] = null;
            }
            $this->coupon_repo->update($coupon, $data);

            if (isset($data['category_id'])) {
                $coupon->categories()->sync($data['category_id']);
            } else {
                $coupon->categories()->detach();
            }

            if (isset($data['product_id'])) {
                $coupon->products()->sync($data['product_id']);
            } else {
                $coupon->products()->detach();
            }
        });
    }
}
