<?php

namespace App\Models\Repositories;

use App\Models\Setting;
use App\Models\Repositories\Contracts\SettingRepositoryInterface;
use App\Models\Repositories\BaseRepository;
use Auth;
use DB;

class SettingRepository extends BaseRepository implements SettingRepositoryInterface {

    protected $model;

    /**
     * UserRepository constructor.
     * @param App\Models\Setting $setting
     */
    public function __construct(Setting $setting) {
        $this->model = $setting;
    }

    /**
     * select all items
     * 
     * @return array
     */
    public function getAll($where_array = array()) {
        $lang_code = getLocale();
        $settings = $this->model->get();
        $new = array();
        if ($settings->count() > 0) {
            foreach ($settings as $one) {
                $name = $one->slug;
                $value = $one->value;
                $value = json_decode($value);
                if (in_array($name, ['general'])) {
                    $value = $value ? $value : [];
                    foreach ($value as $key => $item) {
                        $new[$key] = $item;
                    }
                }else{
                    if($name=='site_info'){
//                        dd($value);
                        $new['site_title'] = $value->title->$lang_code;
                        $new['site_description'] = $value->description->$lang_code;
                        $new['site_address'] = $value->address->$lang_code;
                        $new['site_about'] = $value->about->$lang_code;
                    }else if($name=='home_about'){
                       $new['home_about_title'] = $value->title->$lang_code;
                        $new['home_about_description'] = $value->description->$lang_code;
                       
                    }else if($name=='working_hours'){
//                        dd($value);
                        $new[$name] =(array) $value; 
                       
                    }else{
                       $new[$name] = $value; 
                    }
                   
                }
                
            }
        }
//        dd($new);
        return $new;
    }

    /**
     * find one for edit
     * 
     * @param int $id
     * @return App\Models\Location
     */
    public function findBySlug($slug) {
        $data = $this->model->where('slug',$slug)->first();
        return $data;
    }

    public function update($slug, $data = []) {

        $this->model->where('slug', $slug)->update($data);

    }

    

    /**
     * select all records for datatable
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable() {
        return $this->model->get()->keyBy('name');
    }

}
