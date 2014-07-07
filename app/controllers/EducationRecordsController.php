<?php

class EducationRecordsController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |	Route::get('/', 'HomeController@showWelcome');
    |
    */



    public function create($id)
    {
        $doctor = \App\Models\Doctor::find($id);
        return View::make('education_records.create')-> with('doctor', $doctor);
    }

    public function store($id)
    {
        $doctor = \App\Models\Doctor::find($id);
        //TODO check if current_user and if current_user is owner/admin of a doctor
        $rules = array(
            'type'              => 'required',
            'organization_name' => 'required'
        );
        $messages = array();
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return Redirect::route('educationRecord.create', $doctor->id)
                ->withErrors($validator)
                ->withInput();
        } else {
            $educationRecord = \App\Models\EducationRecord::create(array(
                'type' => Input::get('type'),
                'doctor_id' => $doctor->id,
                'organization_name' => Input::get('organization_name'),
                'graduation_year' => Input::get('graduation_year')
            ));


            return Redirect::route('showDoctor', $doctor->id)-> with('doctor', $doctor);
        }
    }

    public function destroy($id, $education_record_id)
    {
        $doctor = \App\Models\Doctor::find($id);
        $educationRecord = \App\Models\EducationRecord::find($education_record_id);
        $educationRecord->delete();
        return Redirect::route('showDoctor', $doctor->id)-> with('doctor', $doctor);
    }

    public function edit($id, $education_record_id)
    {
        $doctor = \App\Models\Doctor::find($id);
        $education = \App\Models\EducationRecord::find($education_record_id);

        return View::make('education_records.edit')-> with('doctor', $doctor)-> with('education', $education);

    }

    public function update($id, $education_record_id)
    {
        $doctor = \App\Models\Doctor::find($id);
        $education_record = \App\Models\EducationRecord::find($education_record_id);

        $rules = array(
            'type'              => 'required',
            'organization_name' => 'required'
        );
        $messages = array();
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return Redirect::route('educationRecord.edit', array($doctor->id, $education_record->id))
                ->withErrors($validator)
                ->withInput();
        } else {
            $educationRecord = $education_record->update(array(
                'type' => Input::get('type'),
                'doctor_id' => $doctor->id,
                'organization_name' => Input::get('organization_name'),
                'graduation_year' => Input::get('graduation_year')
            ));

            return Redirect::route('showDoctor', $doctor->id)-> with('doctor', $doctor);
        }
    }

}
