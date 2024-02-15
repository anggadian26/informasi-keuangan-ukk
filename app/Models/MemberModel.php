<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberModel extends Model
{
    protected $table = 'member';
    protected $primaryKey = 'member_id';

    protected $guarded = [];
}
