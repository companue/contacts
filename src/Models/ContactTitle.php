<?php

namespace Companue\Contacts\Models;

use Illuminate\Database\Eloquent\Model;

class ContactTitle extends Model
{
    // protected $table = 'contact_titles';
    protected $fillable = ['creator_id', 'lang', 'title'];
}
