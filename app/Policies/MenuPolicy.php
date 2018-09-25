<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function index(User $user)
    {
        if ($user->can('see_menus') || $user->can('manage_menus')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create menus.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->can('create_menu') || $user->can('manage_menus')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can edit the menu.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function edit(User $user)
    {
        if ($user->can('see_links')) {
            return true;
        }

        if ($user->can('update_menu') || $user->can('manage_menus')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the menu.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        if ($user->can('update_menu') || $user->can('manage_menus')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the menu.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        if ($user->can('delete_menu') || $user->can('manage_menus')) {
            return true;
        }

        return false;
    }
}
