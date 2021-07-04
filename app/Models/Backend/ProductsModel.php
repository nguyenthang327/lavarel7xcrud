<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    //
    // khai bao ten bang
    protected $table = 'products';

    // khai bao ten khoa chinh cua bang
    protected $primaryKey = 'id';
}
