<?php
/**
 * Created by PhpStorm.
 * User: vuk
 * Date: 23.2.17.
 * Time: 19.59
 */

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Eloquent {
    use SoftDeletes;
}