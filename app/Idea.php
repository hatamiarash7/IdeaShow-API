<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

require(app_path() . '\Common\jdf.php');

class Idea extends Model
{
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}