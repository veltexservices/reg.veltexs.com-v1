<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'registration_no',

        'email',
        'title',
        'first_name',
        'last_name',
        'full_name',
        'gender',

        'job_title',
        'job_function',
        'phone',

        'company_name',
        'address',

        'country',
        'pincode',
        'state',
        'city',
        'website',

        'industry_segment',
        'business_nature',

        'primary_product_group',
        'additional_product_group',

        'terms',
        'agree_children_policy',
        'status',
    ];

    protected $casts = [
        'terms' => 'boolean',
        'agree_children_policy' => 'boolean',
        'additional_product_group' => 'array',
        'status' => 'boolean',
    ];
}