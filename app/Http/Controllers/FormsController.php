<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormsController extends Controller
{
    private $form_id;

    public function createForm(Request $request)
    {
        $request=$request->getContent();
        $request_data=json_decode($request);
        $id = DB::table ('forms') ->insertGetId(
            [   'title' => $request_data->title,
                'device_type' => $request_data->device_Type,
                'form_type' => $request_data->form_Type
            ]

        );
        if($request_data->isActive == "Y")
            $is_active=1;
        else
            $is_active=0;
        DB::table ('form_config') ->insert(
            [   'version' => $request_data->version,
                'config' => $request_data->config,
                'is_active' => $is_active,
                'form_id' => $id
            ]
        );
        DB::table ('client_forms') ->insert(
            [   'client_id' => $request_data->clientId,
                'form_id' => $id
            ]
        );
    }

    public function getFormsByID()
    {

    }

    public function getAllForms(Request $request,$clientId)
    {
        $data = DB::table('client_forms')
            ->join('forms', 'client_forms.form_id', '=', 'forms.form_id')
            ->join('form_config', 'client_forms.form_id', '=', 'form_config.form_id')
            ->where('client_forms.client_id',$clientId)
            ->select('form_config.form_id',
                'client_forms.client_id',
                'client_forms.client_forms_id',
                'forms.title',
                'forms.form_type',
                'forms.device_type',
                DB::raw("MAX(form_config.version) as version"),
                'form_config.config')
            ->groupBy('form_config.form_id',
                'client_forms.client_id',
                'client_forms.client_forms_id',
                'forms.title',
                'forms.form_type',
                'forms.device_type',
                'form_config.config')
            ->get();
        $form_data= json_encode($data);
        return $form_data;
    }

    public function updateForm(Request $request,$formId)
    {

        $isDisable=$request->get('IsDisable');
        if(isset($isDisable))
        {
            $this->disableForm($request,$formId,$isDisable);
        }
        else{
            $request=$request->getContent();
            $request_data=json_decode($request);
            $data = DB::table('form_config')->where('form_id', $formId)->orderBy('version', 'desc')->first();
            $version=$data->version +1;

            DB::table ('form_config') ->insert(
                [   'version' => $version,
                    'config' => $data->config,
                    'is_active' => 1,
                    'form_id' => $data->form_id
                ]
            );
            DB::table('form_config')
                ->where('form_id', $data->form_id)
                ->where('version',$data->version)
                ->update(['is_active' => 0]);
        }
    }

    public function disableForm(Request $request,$formId,$isDisable)
    {
        if($isDisable === true){
            DB::table('form_config')
                ->where('form_id', $formId)
                ->update(['is_active' => 0]);
        }else{
            $data = DB::table('form_config')->where('form_id', $formId)->orderBy('version', 'desc')->first();
            DB::table('form_config')
                ->where('form_id', $formId)
                ->where('version',$data->version)
                ->update(['is_active' => 1]);
        }
    }

    public function delete(Request $request,$formId)
    {
        DB::table('forms')->where('form_id', '=', $formId)->delete();
        DB::table('form_config')->where('form_id', '=', $formId)->delete();
        DB::table('client_forms')->where('form_id', '=', $formId)->delete();
    }
}