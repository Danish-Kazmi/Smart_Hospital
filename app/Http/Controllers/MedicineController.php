<?php

namespace App\Http\Controllers;

use App\Medicine;
use App\Patients;
use App\Prescription;
use App\Appointment;
//use Illuminate\Support\Facades\Storage;
use App\Prescription_Medicine;
use App\User;
//use App\Appointment;
//use File;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

//use stdClass;
//use Carbon\Carbon;
//use Auth;

class MedicineController extends Controller
{
    //

    public function registerMed() {
        $user = Auth::user();
        $title = "Register Medicine";
        $patient = DB::table('patients')->select('id', 'name')->get();
        $doctor = DB::table('users')->select('id', 'name')->where('user_type', 'doctor')->get();
        $appointment = DB::table('appointments')->select('id', 'number')->get();
        $medicine = DB::table('medicines')->select('id', 'name_english as name')->get();
        return view('medicine.register_medicine',compact('user','title','patient','doctor','appointment','medicine'));
    }


    public function registerpres(Request $request) {
        $validator = Validator::make($request->all(),[
            'p_id' => 'required|max:10',
            'd_id' => 'required|max:10',
            'a_id' => 'required|max:10',
            'status' => 'required',
        ]);

        if($validator->passes()) {
            // Insert Data
            $data = $request->input();
			try{
				$prescript = new Prescription;
                $prescript->patient_id = $data['p_id'];
                $prescript->doctor_id = $data['d_id'];
				$prescript->appointment_id = $data['a_id'];
				$prescript->medicine_issued = $data['status'];
				$prescript->bp = $data['bp'];
				$prescript->cholestrol = $data['chol'];
				$prescript->blood_sugar = $data['sugar'];
				$prescript->diagnosis = $data['diag'];
				$prescript->medicines = count($data['med_name']);
                $prescript->save();
                $prescriptionId= DB::table('prescriptions')->where('appointment_id', $data['a_id'])->value('id');
                for ($i = 0; $i < count($data['med_name']); $i++) {
                    $preMed = new Prescription_Medicine;
                    $preMed->prescription_id = $prescriptionId;
                    $preMed->medicine_id  = $data['med_name'][$i];
                    $preMed->note = $data['med_desc'][$i];
                    $preMed->issued = $data['status'];
                    $preMed->save();
                }
                $successtxt = "Prescrition has been added with ID: $prescriptionId!";
                $request->session()->flash('prescriptionSuccess', $successtxt);
                return redirect('/register-receipt');
			}
			catch(Exception $e){
                return redirect('/register-receipt')->withErrors($validator)->withInput();
			}
        } else {
            // Error
            return redirect('/register-receipt')->withErrors($validator)->withInput();
        }
    }

    public function editMed($presid) {
        $user = Auth::user();
        $title = "Register Medicine";
        $prescription = DB::table('prescriptions')->where('id',$presid)->get();
        $patient = DB::table('patients')->select('id', 'name')->get();
        $doctor = DB::table('users')->select('id', 'name')->where('user_type', 'doctor')->get();
        $appointment = DB::table('appointments')->select('id', 'number')->get();
        $medicine = DB::table('medicines')->select('id', 'name_english as name')->get();
        $prescription_Med = Prescription_Medicine::where('prescription_id', $presid)->select('medicine_id','note')->get();
        return view('medicine.edit_medicine',compact('user','title','prescription','patient','doctor','appointment','medicine','prescription_Med','presid'));
    }

    public function markIssued(Request $request){
        try {
            $pres_med=Prescription_Medicine::find($request->medid);
            $pres_med->issued="YES";
            $pres_med->save();
            $med=Medicine::find($pres_med->medicine_id);
            $med->qty+=1;
            $med->save();
            return response()->json([
                "code"=>200,
                "prescription"=>$request->medid,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "code"=>400,
                "prescription"=>$request->medid,
            ]);
        }
        
    }

    public function medIssueSave(Request $request){
        try {
            $presc=Prescription::find($request->presid);
            $presc->medicine_issued="YES";
            $presc->save();
            $medicines=Prescription_Medicine::where('prescription_id',$request->presid)->get();
            return view('medicine.receipt',compact('presc','medicines'));
        } catch (\Throwable $th) {
           return redirect()->back()->with('error',"Unkown Error Occured");
        }
        
    }

    public function searchSuggestion(Request $request)
    {
        $keyword = $request->keyword;
        return response()->json([
            "sugestion" => ["shakthi", "sachinta", "blov"],
        ], 200);
    }

    public function getherbs()
    {
        $herbs = DB::table('medicines')->get();
        return response()->json($herbs);
    }

    public function issueMedicine($presid){
        $pmedicines=Prescription_Medicine::where('prescription_id',$presid)->get();
        $title="Issue Medicine ($presid)";
        $prescription=Prescription::find($presid);
        $doctor_name=User::where('id',$prescription->doctor_id)->select('name')->get();
        return view('patient.show',compact('pmedicines','title','presid','prescription','doctor_name'));
    }

    public function issueMedicineView()
    {
        $user = Auth::user();
        return view('patient.issueMedicineView', ['title' => "Issue Medicine"]);
    }

    public function prescritionsAll() {
        $prescript = DB::table('prescriptions')->join('patients', 'prescriptions.patient_id', '=', 'patients.id')->join('users', 'prescriptions.doctor_id', '=', 'users.id')->select('prescriptions.*', 'patients.name as patient_name', 'users.name as doctor_name')->get();
        // $prescript = DB::table('prescriptions')->get();
        // foreach ($prescript as $pre) {
            // $patient[] = DB::table('patients')->where('id', $pre->patient_id)->select('name')->get();
        // }
        // $title = "Issue Medicine";
        return view('medicine.all_prescription', ['title' => "Issue Medicine", 'prchi' => $prescript]);
    }

    public function issueMedicineValid(Request $request)
    {
        $num = $request->pNum;
        $numlength = strlen((string) $num);

        if ($numlength < 7) {  //if appointemnt number have been given
            $app = Appointment::whereRaw('date(created_at)=CURDATE()')
                            ->where('id',$num)
                            ->orderBy('created_at','DESC')
                            ->first();
            if ($app) {
                $rec=Prescription::where('appointment_id',$app->id)->first();
                return response()->json([
                    "exist" => true,
                    "name" => $rec->patient->name,
                    "appNum" => $app->number,
                    "pNUM" => $rec->patient_id,
                    "pres_id" => $rec->id,
                ]);
            } else {
                return response()->json([
                    "exist" => false,
                ]);
            }
        } 
        else { //if patient registration number have been given
            $app=Appointment::whereRaw('date(created_at)=CURDATE()')
                            ->where('patient_id',$num)
                            ->orderBy('created_at','DESC')
                            ->first();

            if ($app) {

                $rec=Prescription::where('appointment_id',$app->id)->first();

                return response()->json([
                    "exist" => true,
                    "name" => $rec->patient->name,
                    "appNum" => $app->number,
                    "pNUM" => $rec->patient_id,
                    "pres_id"=>$rec->id,
                ]);
            } else {
                return response()->json([
                    "exist" => false,
                ]);
            }
        }

        
    }

  
}

