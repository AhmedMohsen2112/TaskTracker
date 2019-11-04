<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\AdminController;
use App\Models\Repositories\SettingRepository;
use App\Models\AttachmentFile;
use App\Http\Requests\Admin\SettingsRequest;
use DB;

class SettingsController extends AdminController {

    private $setting;
    public function __construct(SettingRepository $setting) {

        parent::__construct();
        $this->middleware('CheckPermission:settings,open', ['only' => ['index', 'update']]);
        $this->setting=$setting;
    }

    public function index() {

        $this->data['settings'] = $this->setting->datatable();

        return $this->_view('settings/index');
    }

    public function edit($id) {

        $result = $this->setting->findBySlug($id);
        if (!$result) {
            abort(404);
        }
        $result->value = json_decode($result->value);
        $page = $result->slug;
        $this->data['result'] = $result;
        return $this->_view('settings.' . $page, 'backend');
    }

    public function update(Request $request) {

        DB::beginTransaction();
        try {
            $setting = $request->input('setting');
            $slug = $setting['slug'];
            $value = json_encode($setting['value']);
            $this->setting->update($slug,['value' => $value]);

            DB::commit();
            return _json('success', _lang('app.updated_successfully'));
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return _json('error', _lang('app.error_is_occured'), 400);
        }
    }


}
