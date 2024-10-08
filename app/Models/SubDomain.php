<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDomain extends Model
{
    use HasFactory;
    protected $table = 'subdomains';
    protected $fillable = [
'subdomain','domain_name','db_name','name','is_active'
    ];

}
