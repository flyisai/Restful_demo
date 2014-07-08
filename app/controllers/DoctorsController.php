<?php
use \App\Models\Doctor;
class DoctorsController extends BaseController {

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

    public function searchDoctors() {
        if (Request::getMethod() === "GET") {        
            // Get list of doctors
            $doctors = App::make('Doctors\Doctor');
            $doctorList = $doctors->getDoctors(Request::query());
            $specialities = $doctors->getAllSpecialities();
            $specialities[''] = '';
            return View::make('doctors.searchdoctors')
                ->with('specialities', $specialities)
                ->with('doctors', $doctorList);
        } elseif (Request::getMethod() === "POST") {
            $rules = array();
            $messages = array();
            $validator = Validator::make(Input::all(), $rules, $messages);                    
            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            } else {           
                $queryParams = array();
                $queryParams['name'] = Input::get('name');
                if (Input::has('speciality')) {
                    $queryParams['speciality'] = Input::get('speciality');
                }
                return Redirect::route('searchDoctors', $queryParams)
                    ->withInput();
            }
        }
    }


    public function show($id) {
        $owner = false;
        $doctor = \App\Models\Doctor::find($id);
        $user = Sentry::getUser();
        if ($user) {
            $userRatingOfDoc = $user->doctorRatings()->first();
        };
        if (empty($userRatingOfDoc)) {
            $userRatingOfDoc = \App::make('\App\Models\DoctorRating');
        }
        if (empty($doctor)) {
            \App::abort('404');
        }
        $ratingModel = \App::make('\App\Models\DoctorRating');
        $ratingCalculator = \App::make('RatingCalculator', array(
            'ratableEntity' => $doctor,
            'ratingModel' => $ratingModel
        ));
        $ratableFields = array(
            "Friendliness" => "friendliness",
            "Clarity" => "clarity",
            "Trustworthiness" => "trustworthiness",
            "Personal Hygiene" => "personal_hygiene",
            "Listening" => "listening",
            "Wait Time" => "wait_time",
            "Accessibility" => "accessibility"
        );
        if(Sentry::check()) {
            if ($doctor->user_id == Sentry::getUser()->id){
                $owner = true;
            }

        }
        return \View::make('doctors.show')
            ->with('doctor', $doctor)
            ->with('ratingAvgsByField', $ratingCalculator->getAverageRatingByField())
            ->with('combinedAvgRating', $ratingCalculator->getCombinedAverage())
            ->with('ratableFields', $ratableFields)
            ->with('userRatingOfDoc', $userRatingOfDoc)
            ->with('ratingCount', $ratingCalculator->getRatingCount())
            ->with('user', $owner);
    }
    
    public function create() {
        if (Request::getMethod() === "GET") {
            $user = Sentry::getUser();
            if(isset($user->id)) {
                $userid=$user->id;
            } else {
                return Redirect::route('login');        
            }
            return View::make('doctors.profile')                  
                ->with("user_id",$userid)
                ->with("route","doctorstore");                          
        }
    }
    /**
     * 
     * @return type
     */
    public function store() {
        $Doctormodel = new Doctor();     
        $input = Input::get();                
        
        unset($input["_token"]);
        unset($input["post1"]);
        unset($input["id"]);
                
        //VALIDATION CHECK                        
        $rules = array(
                'name'  => 'required|unique:doctors,name',
                'speciality' => 'required',
                'street_address' => 'required',
                'postcode' => 'required',
                'country' => 'required|alpha',
                'phone' => 'required|numeric',
                'email' => 'required|email|unique:doctors,email',
                'license_number' => 'required',
        );

        $messages = array(
                'required' => "The [:attribute]  is required.",
                'alpha' => "The :attribute  only is  letters allowed.",
                'unique' => "The :attribute already exist in database.",
                'email' => "The :attribute  is incorrect email address.",	
                'numeric'=>"The :attribute  only is number.",
        );
        $validation = Validator::make($input, $rules, $messages);
							
        if ($validation->fails()) {
            //Validation has failed.
            return Redirect::back()->withErrors($validation->messages())->withInput();
        }        
        else {
            foreach($input as $key=>$value) {
                $Doctormodel->$key = $value;
            }        
            $Doctormodel->save();          
            return Redirect::route('doctorprofileedit');
        }
    }      
    
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit() {
            $user = Sentry::getUser(); 
            if(isset($user->id))
            $userid=$user->id; 
            else 
            {
                return Redirect::route('login');        
            }
            
            $doctorinfoarr=Doctor::where('user_id', $userid)->get();
            $doctorinfo=$doctorinfoarr[0];      
            return View::make('doctors.profileedit')
                    ->with("doctor",$doctorinfo);
            
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update() {
	//
        $Doctormodel = new Doctor();     
        $input = Input::get();            
        if($input['id'])
            $Doctormodel = $Doctormodel::find($input['id']);
        else
            return Redirect::route('login');
        
        unset($input["_token"]);
        unset($input["post1"]);
                       
        //VALIDATION CHECK                        
        $rules = array(
                'name'  => 'required',
                'speciality' => 'required',
                'street_address' => 'required',
                'postcode' => 'required',
                'country' => 'required|alpha',
                'phone' => 'required|numeric',
                'email' => 'required|email',
                'license_number' => 'required',
        );

        $messages = array(
                'required' => "The [:attribute]  is required.",
                'alpha' => "The :attribute  only is  letters allowed.",
                'unique' => "The :attribute  already exist in database.",
                'email' => "The :attribute  is incorrect email address.",	
                'numeric'=>"The :attribute  only is number.",
        );
        $validation = Validator::make($input, $rules, $messages);
							
        if ($validation->fails()) {
            //Validation has failed.
            return Redirect::back()->withErrors($validation->messages())->withInput();
        }        
        else
        {
            foreach($input as $key=>$value)
            {               
                $Doctormodel->$key = $value;
            }        
            $Doctormodel->save();          
            return Redirect::route('doctorprofileedit');
        }
	}   
//end class    
}
