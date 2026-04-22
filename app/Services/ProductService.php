<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Session\Session;

class ProductService
{
    protected $product_repo;

    public function __construct(ProductRepository $repo)
    {
        $this->product_repo = $repo;
    }

    public function create($data)
    {
        // dd($data);
        $validator = Validator::make($data, [
            'name' => 'required|unique:products,name',
            'sku' => 'required|unique:products,sku',
            'stock_qty' => 'required|numeric',
            'min_qty' => 'required|numeric|min:0',
            'max_qty' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'multiple_image' => 'nullable|array',
            'multiple_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|array',
            'category_id.*' => 'exists:categories,id',
            'attribute_id' => 'nullable|array',
            'attribute_value' => 'nullable|array',
            'attribute_id.*' => 'exists:attributes,id',
            'value_id' => 'nullable|array',
        ]);

        $validator->after(function ($validator) use ($data) {
            $ids = $data['attribute_id'] ?? [];
            $values = $data['attribute_value'] ?? [];

            foreach ($ids as $index => $id) {
                if (!isset($values[$index]) || empty($values[$index])) {
                    $validator->errors()->add('attribute_value.' . $index, 'The attribute value is required for the selected attribute.');
                }
            }
        });

        $validator->after(function ($validator) use ($data) {
            $value_ids = $data['value_id'] ?? [];

            foreach ($value_ids as $option_id => $group) {
                foreach ($group as $group_index => $values) {
                    foreach ($values as $ids => $value_id) {
                        if (empty($value_id)) {
                            $validator->errors()->add("value_id.{$option_id}.{$group_index}.{$ids}", 'Option Value is Selected for the selected option');
                        }
                    }
                }
            }
        });

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        // 
        DB::transaction(function () use ($data) {
            if (isset($data['main_image'])) {
                $file = $data['main_image'];
                $file_name = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $file_name);
            } else {
                $file_name = null;
            }
            $product = $this->product_repo->create([
                'name' => $data['name'],
                'sku' => $data['sku'],

                'stock_qty' => $data['stock_qty'],
                'max_qty' => $data['max_qty'],
                'min_qty' => $data['min_qty'],
                'description' => $data['description'] ?? null,
                'price' => $data['price'],
                'main_image' => $file_name,
                'created_by' => session('admin_id'),
            ]);

            $product->categories()->attach($data['category_id']);

            if (isset($data['multiple_image']) && is_array($data['multiple_image'])) {
                foreach ($data['multiple_image'] as $file) {
                    $file_name = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $file_name);
                    $product->images()->create([
                        'image_url' => $file_name
                    ]);
                }
            }

            if (isset($data['attribute_id']) && is_array($data['attribute_id'])) {
                foreach ($data['attribute_id'] as $index => $attribute_id) {
                    $product->attributes()->create([
                        'attribute_id' => $attribute_id,
                        'attribute_value' => $data['attribute_value'][$index] ?? null
                    ]);
                }
            }

            if (isset($data['discount_qty']) && is_array($data['discount_qty'])) {
                foreach ($data['discount_qty'] as $key => $qty) {
                    $discount_sort_order = $data['discount_sort'][$key] ?? 0;
                    $currencies = $data['discount_currency'][$key] ?? [];
                    $prices     = $data['discount_price'][$key] ?? [];
                    $discount = $product->discounts()->create([
                        'qty' => $qty,
                        'sort_order' => $discount_sort_order
                    ]);

                    foreach ($prices as $pkey => $price) {
                        $currency = $currencies[$pkey] ?? null;
                        $discount->prices()->create([
                            'currency' => $currency,
                            'price'    => $price,
                        ]);
                    }
                }
            }

            if (isset($data['customer_input_options']) || isset($data['value_id'])) {

                $customerInputs = $data['customer_input_options'] ?? [];
                $valueOptions   = $data['value_id'] ?? [];

                $allOptionIds = array_unique(array_merge(
                    array_keys($valueOptions),
                    $customerInputs
                ));

                foreach ($allOptionIds as $option_id) {

                    $isCustomerInput = in_array($option_id, $customerInputs) ? 1 : 0;

                    $productOption = $product->Options()->create([
                        'option_id' => $option_id,
                        'is_customer_input' => $isCustomerInput
                    ]);


                    if ($isCustomerInput) continue;
                    $group = $valueOptions[$option_id] ?? [];

                    foreach ($group as $index => $values) {

                        $value_id = $values[0] ?? null;
                        // dd($value_id);
                        if (!$value_id) continue;

                        $optionValue = $productOption->values()->create([
                            'option_value_id'       => $value_id,
                            'price_operator' => $data['price_operator'][$option_id][$index][0] ?? null,
                            'is_enabled'     => !empty($data['is_enabled'][$option_id][$index][0]) ? 1 : 0,
                        ]);


                        $prices     = $data['options_price'][$option_id][$index] ?? [];
                        $currencies = $data['options_currency'][$option_id][$index] ?? [];

                        foreach ($prices as $pkey => $price) {

                            $currency = $currencies[$pkey] ?? null;

                            if (!$price || !$currency) continue;

                            $optionValue->prices()->create([
                                'currency' => $currency,
                                'price'    => $price,
                            ]);
                        }


                        if (isset($data["value_images"][$option_id][$index])) {

                            foreach ($data["value_images"][$option_id][$index] as $img) {

                                $file_name = time() . '_' . $img->getClientOriginalName();
                                $img->move(public_path('uploads'), $file_name);
                                // $path = $img->store('option_values', 'public');

                                $optionValue->images()->create([
                                    'image_url' => $file_name
                                ]);
                            }
                        }
                    }
                }
            }
        });

        // $this->product_repo->create($data);
    }

    public function getAll()
    {
        return $this->product_repo->get_all();
    }

    public function delete($id)
    {
        $product = $this->product_repo->find($id);
        $this->product_repo->delete($product);
    }

    public function update($id, $data)
    {
        $validator = Validator::make($data, [
            'name' => [
                'required',
                Rule::unique('products', 'name')->ignore($id)
            ],
            'sku' => [
                'required',
                Rule::unique('products', 'sku')->ignore($id)
            ],
            'stock_qty' => 'required|numeric',
            'min_qty' => 'required|numeric|min:0',
            'max_qty' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'multiple_image' => 'nullable|array',
            'multiple_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|array',
            'category_id.*' => 'exists:categories,id',
            'attribute_id' => 'nullable|array',
            'attribute_value' => 'nullable|array',
            'attribute_id.*' => 'exists:attributes,id',
            'value_id' => 'nullable|array',
        ]);

        $validator->after(function ($validator) use ($data) {
            $ids = $data['attribute_id'] ?? [];
            $values = $data['attribute_value'] ?? [];

            foreach ($ids as $index => $id) {
                if (!isset($values[$index]) || empty($values[$index])) {
                    $validator->errors()->add('attribute_value.' . $index, 'The attribute value is required for the selected attribute.');
                }
            }
        });

        $validator->after(function ($validator) use ($data) {
            $value_ids = $data['value_id'] ?? [];

            foreach ($value_ids as $option_id => $group) {
                foreach ($group as $group_index => $values) {
                    foreach ($values as $ids => $value_id) {
                        if (empty($value_id)) {
                            $validator->errors()->add("value_id.{$option_id}.{$group_index}.{$ids}", 'Option Value is Selected for the selected option');
                        }
                    }
                }
            }
        });

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        DB::transaction(function () use ($id, $data) {
            $product = $this->product_repo->find($id);
            $product->update([
                'name' => $data['name'],
                'sku' => $data['sku'],
                'stock_qty' => $data['stock_qty'],
                'max_qty' => $data['max_qty'],
                'min_qty' => $data['min_qty'],
                'description' => $data['description'] ?? null,
                'price' => $data['price'],

            ]);

            $product->categories()->sync($data['category_id'] ?? []);

            if (!empty($data['main_image'])) {
                if ($product->main_image && file_exists(public_path('uploads/' . $product->main_image))) {
                    unlink(public_path('uploads/' . $product->main_image));
                }

                $file = $data['main_image'];
                $file_name = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $file_name);

                $product->update(['main_image' => $file_name]);
            }

            if (isset($data['existing_images'])) {
                $product->images()->whereNotIn('id', $data['existing_images'])->each(function ($img) {
                    if (file_exists(public_path('uploads/' . $img->image_url))) {
                        unlink(public_path('uploads/' . $img->image_url));
                    }
                    $img->delete();
                });
            } else {
                $product->images()->each(function ($img) {
                    if (file_exists(public_path('uploads/' . $img->image_url))) {
                        unlink(public_path('uploads/' . $img->image_url));
                    }
                    $img->delete();
                });
            }

            if (isset($data['multiple_image'])) {
                foreach ($data['multiple_image'] as $file) {
                    $file_name = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $file_name);
                    $product->images()->create([
                        'image_url' => $file_name
                    ]);
                }
            }

            $product->discounts()->delete();
            if (isset($data['discount_qty']) && is_array($data['discount_qty'])) {
                foreach ($data['discount_qty'] as $key => $qty) {
                    $discount_sort_order = $data['discount_sort'][$key] ?? 0;
                    $currencies = $data['discount_currency'][$key] ?? [];
                    $prices     = $data['discount_price'][$key] ?? [];
                    $discount = $product->discounts()->create([
                        'qty' => $qty,
                        'sort_order' => $discount_sort_order
                    ]);

                    foreach ($prices as $pkey => $price) {
                        $currency = $currencies[$pkey] ?? null;
                        $discount->prices()->create([
                            'currency' => $currency,
                            'price'    => $price,
                        ]);
                    }
                }
            }

            $product->attributes()->delete();
            if (isset($data['attribute_id']) && is_array($data['attribute_id'])) {
                foreach ($data['attribute_id'] as $index => $attribute_id) {
                    $product->attributes()->create([
                        'attribute_id' => $attribute_id,
                        'attribute_value' => $data['attribute_value'][$index] ?? null
                    ]);
                }
            }

            // options data
            $valueOptions   = $data['value_id'] ?? [];
            $customerInputs = $data['customer_input_options'] ?? [];

            // all option ids
            $allOptionIds = array_unique(array_merge(
                array_keys($valueOptions),
                $customerInputs
            ));

            foreach ($allOptionIds as $option_id) {

                $isCustomerInput = in_array($option_id, $customerInputs);

                // create/update option
                $productOption = $product->options()->updateOrCreate(
                    ['option_id' => $option_id],
                    ['is_customer_input' => $isCustomerInput]
                );

                // if customer input → no values
                if ($isCustomerInput) {
                    $productOption->values()->delete();
                    continue;
                }

                $values = $valueOptions[$option_id] ?? [];

                foreach ($values as $index => $group) {

                    $value_id = $group[0] ?? null;
                    if (!$value_id) continue;

                    // create/update value
                    $optionValue = $productOption->values()->updateOrCreate(
                        ['option_value_id' => $value_id],
                        [
                            'price_operator' => $data['price_operator'][$option_id][$index][0] ?? null,
                            'is_enabled'     => !empty($data['is_enabled'][$option_id][$index][0]) ? 1 : 0,
                        ]
                    );



                    $existing = $data['existing_option_images'][$option_id][$index] ?? [];

                    // delete removed
                    foreach ($optionValue->images as $img) {
                        if (!in_array($img->id, $existing)) {
                            @unlink(public_path('uploads/' . $img->image_url));
                            $img->delete();
                        }
                    }

                    // add new
                    if (!empty($data['value_images'][$option_id][$index])) {
                        foreach ($data['value_images'][$option_id][$index] as $file) {

                            if ($file) {
                                $name = time() . '_' . $file->getClientOriginalName();
                                $file->move(public_path('uploads'), $name);

                                $optionValue->images()->create([
                                    'image_url' => $name
                                ]);
                            }
                        }
                    }

                    $optionValue->prices()->delete();

                    if (!empty($data['options_currency'][$option_id][$index])) {
                        foreach ($data['options_currency'][$option_id][$index] as $i => $currency) {

                            $price = $data['options_price'][$option_id][$index][$i] ?? null;

                            if ($currency && $price) {
                                $optionValue->prices()->create([
                                    'currency' => $currency,
                                    'price'    => $price
                                ]);
                            }
                        }
                    }
                }
            }

            if (!empty($data['removed_options'])) {
//   dd($data['removed_options']);
                // $ids = explode(',', $data['removed_options']);
   $ids=$data['removed_options'];
                foreach ($ids as $option_id) {

                    $product->options()
                        ->where('option_id', $option_id)
                        ->get()
                        ->each(function ($opt) {

                            // delete images also
                            foreach ($opt->values as $val) {
                                foreach ($val->images as $img) {
                                    @unlink(public_path('uploads/' . $img->image_url));
                                }
                            }

                            $opt->delete(); // cascade delete
                        });
                }
            }
        });
    }
}
