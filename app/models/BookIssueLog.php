<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookIssueLog extends Model
{
    protected $guarded = [];
    public function book_issue()
    {
        return $this->hasMany(BookIssue::class);
    }
}
