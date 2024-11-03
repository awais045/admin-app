<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubDomain extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'subdomains';
    protected $fillable = [
                'subdomain','domain_name','db_name','name','is_active' ,
                'db_user','db_password','domain_dns1','domain_dns2','lamda_response',
                'hostname'
    ];
    protected $dates = ['deleted_at'];

}
