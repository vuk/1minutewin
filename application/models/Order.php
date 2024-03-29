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
        return $this->belongsTo('Product', 'product_id');
    }

    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }
}