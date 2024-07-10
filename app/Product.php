<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{ 
     protected $table = 'products';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description','sku', 'price','ratings'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'product_categories', 'product_id', 'category_id')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'product_id');
    }

    public function feedbacks()
    {
        return $this->hasMany('App\Feedback', 'product_id');
    }

}
