<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
        use Notifiable;

    protected $table = 'admins';
    protected $fillable = ['first_name', 'last_name', 'admin_group_id', 'username', 'email', 'password', 'status', 'accessed_tabs','removed_tabs'];

    public function adminGroup()
    {
        return $this->belongsTo(AdminGroup::class, 'admin_group_id');
    }

    protected $casts = [
        'accessed_tabs' => 'array',
        'removed_tabs'=>'array'
    ];

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAllTabsAttribute()
    {
        $group_tabs = $this->adminGroup->accessed_tabs ?? [];
        $user_tabs = $this->accessed_tabs ?? [];
        return array_values(array_diff(
            array_merge($group_tabs, $user_tabs ?? []),
            $this->removed_tabs ?? []
        ));

        // $all_tabs = array_unique(array_merge($group_tabs, $user_tabs));
        // return $all_tabs;
    }

    public function hasAccess($tab)
    {
        return in_array($tab, $this->all_tabs);
    }
}
