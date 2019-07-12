<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class School extends Model
{
    use SearchableTrait;
    
    protected $fillable = ['name', 'address', 'about'];
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'schools.name' => 10,
            'schools.address' => 10,
            'schools.about' => 10
        ],
  ];
    public function educations(){
        return $this->hasMany('App\Education');
    }

}
