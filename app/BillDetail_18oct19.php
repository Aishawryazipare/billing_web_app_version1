<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    public $table = "tbl_AddBillDetail";
    public $timestamps=false;
    protected $fillable = [
        'bill_no','item_name','item_qty','item_rate','item_totalrate','created_at_TIMESTAMP','updated_at_TIMESTAMP','isactive'
    ];
}
