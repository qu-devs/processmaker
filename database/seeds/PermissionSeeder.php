<?php

use Illuminate\Database\Seeder;
use ProcessMaker\Models\User;
use ProcessMaker\Models\Group;
use ProcessMaker\Models\GroupMember;
use ProcessMaker\Models\Permission;

class PermissionSeeder extends Seeder
{
    private $permissions = [
        'archive-processes',
        'create-categories',
        'create-comments',
        'create-environment_variables',
        'create-groups',
        'create-processes',
        'create-screens',
        'create-scripts',
        'create-users',
        'delete-categories',
        'delete-comments',
        'delete-environment_variables',
        'delete-groups',
        'delete-screens',
        'delete-scripts',
        'delete-users',
        'edit-categories',
        'edit-comments',
        'edit-environment_variables',
        'edit-groups',
        'edit-processes',
        'edit-screens',
        'edit-scripts',
        'edit-users',
        'view-all_requests',
        'view-auth-clients',
        'view-categories',
        'view-comments',
        'view-environment_variables',
        'view-groups',
        'view-processes',
        'view-screens',
        'view-scripts',
        'view-users',
    ];
    
    private $apiPermissions = [
        'view-tasks',
        'edit-tasks',
        'create-requests',
        'view-requests',
        'edit-requests',
        'delete-requests',
        'create-files',
        'view-files',
        'edit-files',
        'delete-files',
        'create-notifications',
        'view-notifications',
        'edit-notifications',
        'delete-notifications',
        'create-task_assignments',
        'view-task_assignments',
        'edit-task_assignments',
        'delete-task_assignments',
        'create-comments',
        'view-comments',
        'edit-comments',
        'delete-comments',
    ];

    private $resourcePermissions = [
        'requests'
    ];

    public function run(User $user = null)
    {
        if (Permission::count() === 0) {
            $group = factory(Group::class)->create([
                'name' => 'All Permissions',
            ]);

            if ($user = User::first()) {
                factory(GroupMember::class)->create([
                    'group_id' => $group->id,
                    'member_type' => User::class,
                    'member_id' => $user->id,
                ]);
            }

            foreach ($this->permissions as $permissionString) {
                $permission = factory(Permission::class)->create([
                    'title' => ucwords(preg_replace('/(\-|_)/', ' ',
                            $permissionString)),
                    'name' => $permissionString,
                ]);
            }
            
            foreach ($this->apiPermissions as $permissionString) {
                $permission = factory(Permission::class)->create([
                    'title' => ucwords(preg_replace('/(\-|_)/', ' ',
                            $permissionString)),
                    'name' => 'api.' . $permissionString,
                ]);
            }
        }

        if ($user) {
            $permissions = Permission::all()->pluck('id');
            $user->permissions()->attach($permissions);
            $user->save();
        }
    }
}
