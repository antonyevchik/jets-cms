<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Livewire\WithPagination;

class NavigationMenu extends Model
{
    use HasFactory, WithPagination;

    protected $fillable = [
        'label',
        'slug',
        'sequence',
        'type'
    ];

    protected $guarded = [];
}
