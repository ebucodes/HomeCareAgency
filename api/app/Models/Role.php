<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded = [];

    const admin = 1;
    const client = 2;
    const staff = 3;

    public function toArray()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "isActive" => true,
        ];
    }
}
