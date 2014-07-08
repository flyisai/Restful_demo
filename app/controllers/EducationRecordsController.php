<?php
use \App\Models\Doctor;
use \App\Models\EducationRecord;
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
        $doctor = Doctor::find($id);
        $user = Sentry::getUser();

        if ($doctor->user_id == $user->id ) {
            return View::make('education_records.create')-> with('doctor', $doctor);
        } else {
            return Redirect::route('searchDoctors');
        }
    }

    public function store($id)
    {
        $doctor = Doctor::find($id);
        $user = Sentry::getUser();

        if ($doctor->user_id == $user->id) {
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
                $educationRecord = EducationRecord::create(array(
                    'type' => Input::get('type'),
                    'doctor_id' => $doctor->id,
                    'organization_name' => Input::get('organization_name'),
                    'graduation_year' => Input::get('graduation_year')
                ));


                return Redirect::route('showDoctor', $doctor->id)-> with('doctor', $doctor);
            }
        } else {
            return Redirect::route('searchDoctors');
        }
    }

    public function destroy($id, $education_record_id)
    {
        $doctor = Doctor::find($id);
        $user = Sentry::getUser();

        if ($doctor->user_id == $user->id) {
            $educationRecord = EducationRecord::find($education_record_id);
            $educationRecord->delete();
            return Redirect::route('showDoctor', $doctor->id)-> with('doctor', $doctor);
        } else {
            return Redirect::route('searchDoctors');
        }
    }

    public function edit($id, $education_record_id)
    {
        $doctor = Doctor::find($id);
        $education = EducationRecord::find($education_record_id);

        return View::make('education_records.edit')-> with('doctor', $doctor)-> with('education', $education);

    }

    public function update($id, $education_record_id)
    {
        $doctor = Doctor::find($id);
        $user = Sentry::getUser();

        if ($doctor->user_id == $user->id) {
            $education_record = EducationRecord::find($education_record_id);

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
        } else {
            return Redirect::route('searchDoctors');
        }
    }

}
