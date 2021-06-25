<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
/*    protected $fillable = [
        'user_id', 'book'
    ];
*/
protected $table = 'my_books';
protected $guarded = [];

public function user(){
	return $this->belongsTo('App\user','user_id','id');
}

}
