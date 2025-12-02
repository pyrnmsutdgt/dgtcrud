<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnrollmentDetail extends Model
{
    public $table = 'enrollment_details'; // บอก Laravel ว่านี่คือ View
    public $timestamps = false; // View ไม่มี created_at/updated_at ของตัวเอง
}
