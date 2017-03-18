<?php
/**
 * Created by PhpStorm.
 * User: vuk
 * Date: 23.2.17.
 * Time: 19.59
 */

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Eloquent {
    use SoftDeletes;

    protected $hidden = array('password', 'fb_Id', 'google_id');

    public function orders()
    {
        return $this->hasMany('Order', 'user_id');
    }
}