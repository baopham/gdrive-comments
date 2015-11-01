<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GDriveFile extends Model
{
    protected $table = 'gdrive_files';

    protected $fillable = ['name', 'file_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
