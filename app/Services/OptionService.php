<?php

namespace App\Services;

use App\Repositories\OptionRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OptionService
{
    protected $repo;

    public function __construct(OptionRepository $repo)
    {
        $this->repo = $repo;
    }

    public function create($data)
    {

        $validator = Validator::make($data, [
            'option_name' => 'required|unique:options,option_name',
            'option_type_id' => 'required|in:select,radio,checkbox,text,textarea,file,date',
            'option_values' => 'exclude_unless:option_type_id,select,radio,checkbox|array',
            'option_values.*.value' => 'exclude_unless:option_type_id,select,radio,checkbox|string|distinct',
            'option_values.*.sort_order' => 'exclude_unless:option_type_id,select,radio,checkbox|integer|distinct',
            'option_values.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'option_name.required' => 'Option name is required.',
            'option_name.unique' => 'Option name must be unique.',
            'option_type_id.required' => 'Option type is required.',
            'option_type_id.in' => 'Option type must be one of: select, radio, checkbox, text, textarea, file, date.',
            'option_values.array' => 'Option values must be an array.',
            'option_values.*.value.string' => 'Each option value must be a string.',
            'option_values.*.value.distinct' => 'Option values must be distinct.',
            'option_values.*.sort_order.integer' => 'Each sort order must be an integer.',
            'option_values.*.sort_order.distinct' => 'Sort orders must be distinct.',
            'option_values.*.image.image' => 'Each option value image must be an image file.',
            'option_values.*.image.mimes' => 'Each option value image must be a file of type: jpeg, png, jpg, gif, svg.',
            'option_values.*.image.max' => 'Each option value image may not be greater than 2048 kilobytes.',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        // dd($data);
        DB::transaction(function () use ($data) {
            $option = $this->repo->create([
                'option_name' => $data['option_name'],
                'option_type_id' => $data['option_type_id'],
                'created_by' => session('admin_id')
            ]);

            if (in_array($data['option_type_id'], ['select', 'checkbox', 'radio'])) {
                foreach ($data['option_values'] as $value) {
                    $file_name = null;

                    if (isset($value['image'])) {
                        $file = $value['image'];
                        if ($file) {
                            $file_name = time() . '_' . $file->getClientOriginalName();
                            $file->move(public_path('uploads'), $file_name);
                        }
                    }

                    $new =  $option->values()->create([
                        'value_name' => $value['value'],
                        'sort_order' => $value['sort_order'],
                        'image' => $file_name
                    ]);

                
                }
                
            }
        });
    }

    public function getAll()
    {
        return $this->repo->getAll();
    }

    public function delete($id)
    {
        $attribute = $this->repo->find($id);
        return $this->repo->delete($attribute);
    }

    public function edit($id)
    {
        return $this->repo->get_by_id($id);
    }


    public function update($id, $data)
    {
        // dd($id, $data);
        $validator = Validator::make($data, [
            'option_name' => [
                'required',
                Rule::unique('options', 'option_name')->ignore($id),
            ],
            'option_type_id'               => 'required|in:select,radio,checkbox,text,textarea,file,date',
            'option_values'                => 'exclude_unless:option_type_id,select,radio,checkbox|required|array|min:1',
            'option_values.*.value'        => 'exclude_unless:option_type_id,select,radio,checkbox|required|string|distinct',
            'option_values.*.sort_order'   => 'exclude_unless:option_type_id,select,radio,checkbox|required|integer|distinct',
            'option_values.*.image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'option_name.required'               => 'Option name is required.',
            'option_name.unique'                 => 'This option name already exists.',
            'option_type_id.required'            => 'Please select an option type.',
            'option_values.required'             => 'At least one option value is required.',
            'option_values.*.value.required'     => 'Each option value name is required.',
            'option_values.*.value.distinct'     => 'Option value names must be unique.',
            'option_values.*.sort_order.required' => 'Each sort order is required.',
            'option_values.*.sort_order.integer' => 'Sort order must be a number.',
            'option_values.*.sort_order.distinct' => 'Sort order values must be unique.',
        ]);


        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        DB::transaction(function () use ($data, $id) {
            $option = $this->repo->find($id);
            $option->update([
                'option_name' => $data['option_name'],
                'option_type_id' => $data['option_type_id'],
            ]);



            if (in_array($data['option_type_id'], ['select', 'checkbox', 'radio'])) {
                // $option->values()->delete();

                $existing_id = [];

                foreach ($data['option_values'] as $value) {
                    // dd($value);
                    $file_name = null;

                    if (!empty($value['id'])) {
                        $option_value = $option->values()->find($value['id']);
                        $existing_id[] = $value['id'];

                        if (isset($value['image']) && $value['image']) {
                            if ($option_value->image  && file_exists(public_path('uploads/' . $option_value->image))) {
                                unlink(public_path('uploads/' . $option_value->image));
                            }

                            $file = $value['image'];
                            if ($file) {
                                $file_name = time() . '_' . $file->getClientOriginalName();
                                $file->move(public_path('uploads'), $file_name);
                            }
                        } else {
                            $file_name = $option_value->image;
                        }

                        $option_value->update([
                            'value_name' => $value['value'],
                            'sort_order' => $value['sort_order'],
                            'image' => $file_name
                        ]);
                    } else {
                        if (isset($value['image']) && $value['image']) {
                            $file = $value['image'];
                            if ($file) {
                                $file_name = time() . '_' . $file->getClientOriginalName();
                                $file->move(public_path('uploads'), $file_name);
                            }
                        }

                      $new=  $option->values()->create([
                            'value_name' => $value['value'],
                            'sort_order' => $value['sort_order'],
                            'image' => $file_name
                        ]);

                        $existing_id[]=  $new->id;
                    }
                }

                $option->values()->whereNotIn('id', $existing_id)->delete();
            } else {
                $option->values()->delete();
            }
        });
    }
}
