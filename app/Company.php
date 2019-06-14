<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Company extends Model
{
    protected $fillable = ['user_id', 'name', 'address', 'about'];
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'companies.name' => 10,
            'companies.address' => 10,
            'companies.about' => 10
        ],
  ];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function works(){
        return $this->hasMany('App\Work');
    }
}
