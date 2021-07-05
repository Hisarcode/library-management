<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookIssueLog extends Model
{
    public function book_issue()
    {
        return $this->hasMany(BookIssue::class);
    }
    
}
