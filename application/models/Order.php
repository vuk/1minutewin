<?php
/**
 * Created by PhpStorm.
 * User: vuk
 * Date: 23.2.17.
 * Time: 19.59
 */

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Eloquent {
    use SoftDeletes;

    public function product()
    {
        return $this->hasOne('Product', 'id', 'product_id');
    }

    public function user()
    {
        return $this->hasOne('User', 'id', 'user_id');
    }
}