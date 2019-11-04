<?php

namespace App\Models\Filters;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingRequestFilters extends QueryFilters {

    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
        parent::__construct($request);
    }

    public function from($term) {
        return $this->builder->whereRaw("DATE(booking_request.created_at) >= '$term'");
    }
    public function to($term) {
        return $this->builder->whereRaw("DATE(booking_request.created_at) <= '$term'");
    }
    public function hotel($term) {
        return $this->builder->where("booking_request.hotel_id",$term);
    }

     public function status($term) {
         if($term==config('constants.booking_request_status.pending')){
             return $this->builder->whereNull("BS.status");
         }else{
             return $this->builder->where("BS.status", $term);
         }
        
    }
     public function created_by($term) {
        return $this->builder->where("booking_request.client_id", $term);
    }
    public function filters() {
        $params=$this->request->all();
        return $params;
    }

}
