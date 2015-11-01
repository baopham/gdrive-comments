<?php

namespace App\Policies;

use App\GDriveFile;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GDriveFilePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given file can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\GDriveFile  $file
     * @return bool
     */
    public function update(User $user, GDriveFile $file)
    {
        return $user->id === $file->user_id;
    }

    /**
     * Determine if the given file can be deleted by the user.
     *
     * @param  \App\User  $user
     * @param  \App\GDriveFile  $file
     * @return bool
     */
    public function destroy(User $user, GDriveFile $file)
    {
        return $user->id === $file->user_id;
    }
}
