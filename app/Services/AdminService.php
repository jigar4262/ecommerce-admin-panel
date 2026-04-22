<?php

namespace App\Services;

use App\Mail\AdminCreatedMail;
use App\Models\AdminGroup;
use App\Repositories\AdminRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AdminService
{
    protected $admin_repo;
    public function __construct(AdminRepository $adminRepository)
    {
        $this->admin_repo = $adminRepository;
    }

    public function create($data)
    {
        $validator = Validator::make($data, [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'required|unique:admins,email',
            'password' => 'required',
            'admin_group_id' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $group_data = AdminGroup::find($data['admin_group_id']);
        $group_tab = $group_data->accessed_tabs ?? [];

        $user_tabs = $data['accessed_tabs'] ?? [];

        $extra_tabs = array_values(array_diff($user_tabs, $group_tab));
        $removed_tabs = array_values(array_diff($group_tab, $user_tabs));

        $data['removed_tabs'] = $removed_tabs ?? [];
        $data['password'] = Hash::make($data['password']);
        $data['accessed_tabs'] = $extra_tabs ?? [];
        $data['username'] = $data['username'];

        $admin = $this->admin_repo->create($data);
        Mail::to($admin->email)->queue(new AdminCreatedMail($admin, $admin->password));
        return $admin;
    }

    public function getAll()
    {
        return $this->admin_repo->getAll();
    }

    public function delete($id)
    {
        $admin_group = $this->admin_repo->find($id);
        return $this->admin_repo->delete($admin_group);
    }

    public function edit($id)
    {
        return $this->admin_repo->find($id);
    }


    public function update($data, $id)
    {
        $validator = Validator::make($data, [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => ['required', Rule::unique('admins', 'email')->ignore($id)],
            'admin_group_id' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $admin = $this->admin_repo->find($id);
        $group_data = AdminGroup::find($data['admin_group_id']);
        $group_tab = $group_data->accessed_tabs ?? [];

        $user_tabs = $data['accessed_tabs'] ?? [];

        $extra_tabs = array_values(array_diff($user_tabs, $group_tab));
        $removed_tabs = array_values(array_diff($group_tab, $user_tabs));

        $data['removed_tabs'] = $removed_tabs ?? [];
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $data['accessed_tabs'] = $extra_tabs ?? [];
        //    dd($data);


        return $this->admin_repo->update($admin, $data);
    }
}
