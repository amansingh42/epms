<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Field;
use App\Models\Report;
use App\Models\FieldValue;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;

class ReportController extends Controller
{

    function __construct(){
        $this->middleware('permission:report-list|report-create|report-edit|report-delete',['only'=>['index']]);
        $this->middleware('permission:report-create',['only'=>['create','store']]);
        $this->middleware('permission:report-edit',['only'=>['edit','update']]);
        $this->middleware('permission:report-delete',['only'=>['destroy']]);

        $this->admin_role = Role::findByName('Admin');
        $this->hr_role = Role::findByName('Hr');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::paginate(10);
        return view('report.index',compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::whereHas('roles',function(Builder $q){
            $q->where('name','!=','Admin');
        })->get();

        return view('report.rating_form.general_info',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
    * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $general_info = session()->get('gen_info');

        $report = Report::where('user_id',$request->employee_id)
                    ->where('month',$general_info['month'])
                    ->where('year',$request->year)
                    ->first();

        if($report){
            return redirect()->route('report.create')->with('error','Report already exist');
        }else{
            
            if($request->admin_ratings && auth()->user()->roles[0]->id == $this->admin_role->id){
                foreach($request->admin_ratings as $key => $val){
                    $request->validate([
                        'admin_ratings.'.$key => 'required|not_in:0'
                    ]);
                }
            }

            if($request->hr_ratings && auth()->user()->roles[0]->id == $this->hr_role->id){
                foreach($request->hr_ratings as $key => $val){
                    $request->validate([
                        'hr_ratings.'.$key => 'required|not_in:0'
                    ]);
                }
            }

            $admin_rating = 0;
            $hr_rating = 0;
            $ratings = 0;
            $val = 0;
            
            $report = Report::create([
                'user_id' => $request->employee_id,
                'month' => $general_info['month'],
                'year'  => $general_info['year'],
                'admin_remarks' => $request->admin_remarks,
                'admin_deduct_points' => $request->deduct_points
            ]);

            $report_id = $report->id;

            if($request->admin_ratings){
                foreach($request->admin_ratings as $key => $rating){
                    $val += $rating;      // to store average score
                    $admin_rating += $rating;    // to store admin ratings
                    $role_id = $this->admin_role->id;
                    $this->addRatingValue($report_id,$role_id,$key,$rating);
                }
            }

            if($request->hr_ratings){
                foreach($request->hr_ratings as $key => $rating){
                    $val += $rating;
                    $hr_ratings += $rating;
                    $role_id = $key;
                    $this->addRatingValue($report_id,$role_id,$key,$rating); 
                }
            }

            $this->updateAvg($report_id,$request,$val);
            
            if(auth()->user()->roles[0]->id == $this->admin_role->id){
                return redirect()->route('report.edit',$report_id)->with('success','Report has been created successfully.');
            }

            if(auth()->user()->roles[0]->id == $this->hr_roile->id){
                return redirect()->route('report.index')->with('success','Report has been created successfully.');
            }
        }

    }

    public function saveGenInfo(Request $request)
    {
        $existreport = Report::where('user_id',$request->userid)->where('month',$request->month)->where('year',$request->year)->get();
        
        if(count($existreport) > 0){
            return redirect()->route('report.create')->with('error','Report already exists');
        }else{
            $request->validate([
                'userid' => 'required',
                'month'  => 'required',
                'year'   => 'required'
            ]);

            $data = $request->all();

            session()->put('gen_info',$data);

            $emp = User::where('id',$request->userid)->first();
            $fields = Field::get()->toArray();
 
            $admin_fields = [];
            $hr_fields = [];
            $pfmreport = [];

            foreach($fields as $field){
                $role_id = $field['role_id'];
                $field['value'] = null;
                
                if($role_id == $this->admin_role->id && $field['status'] == 1  && in_array($emp->designation_id,explode(',',$field['designation_id'])) ){
                    $admin_fields[] = $field;
                }
                if($role_id == $this->hr_role->id && $field['status'] == 1  && in_array($emp->designation_id,explode(',',$field['designation_id'])) ){
                    $hr_fields[] = $field;
                }
            }

            $deduction_points = count($admin_fields)*10;

            if(auth()->user()->roles[0]->id == $this->admin_role->id){
                return view('report.rating_form.admin_fields',compact('admin_fields','deduction_points','emp','pfmreport'));
            }

            if(auth()->roles[0]->id == $this->hr_role->id){
                return view('report.rating_form.hr_fields',compact('emp','pfmreport','hr_fields'));
            }
        }

        
    }

    public function editHrInfo(Request $request,$id){
        $hr_fields = [];
        $pfmreport = Report::where('id',$id)->first();
        
        $emp = User::join('model_has_roles as r','users.id','=','r.model_id')->select('users.*','r.role_id')->whereNotNull('users.emp_id')->where('r.role_id','!=',Auth::user()->roles[0]->id)->where('users.id',$pfmreport->user_id)->first();
        
        if(!$emp){
            return redirect()->back();
        }

        $allFields = Field::all()->toArray();

        if($pfmreport->ratingvalue){

            foreach($allFields as $field){
                $rating = $this->getFieldValue($id,$field['id']);
                if($field['role_id'] == $this->hr_role->id && $field['status'] == 1 && in_array($emp->designation_id,explode(',',$field['designation_id']))){
                    $hr_fields[]  = [
                                    'id' => $field['id'],
                                    'name' => $field['name'] ,
                                    'value'  => $rating ? $rating->field_value : ''
                                    ];
                }
            }
            
        }
        return view('report.rating_form.hr_fields',compact('pfmreport','emp','hr_fields'));
    }
    /*`*
     * Display the specified resource.
     *`
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        $points = Report::where('user_id',$report->user_id)->orderBy('year','desc')->orderBy('month','desc')->skip(0)->take(6)->get();
        return view('report.show',compact('report','points'));
    }

    public function addRatingValue($report_id,$role_id,$key,$rating){
        
        FieldValue::create([
            'report_id'  => $report_id,
            'field_id'   => $key,
            'field_value'  => $rating,
            'role_id'    => $role_id
        ]);
    }

    public function updateAvg($report_id,$request,$val){
        $points = $val;
        $pfmr = new Report;
        $ratings = 0;

        if($request->admin_ratings){
            $hr_points = $pfmr->where('id',$report_id)->pluck('hr_points')->first();

            $hrfields = 0;
            $ratings += $hr_points;

            if($hr_points != 0 ){
                $hrfields = $this->countFields($report_id,$this->hr_role->id);
            }

            $total_points = ($hrfields + count($request->admin_ratings) ) * 10;
            $ratings = $ratings - $request->deduct_points;
            $avg = ($ratings / $total_points) * 100;

            $pfmr->where('id',$report_id)
                ->update([
                    'avg_points' => $avg,
                    'admin_points' => $points
                ]);

        }

        if($request->hr_ratings){
            $admin_points = $pfmr->where('id',$report_id)->pluck('admin_points')->first();

            $adminfields = 0;
            $ratings += $admin_points;

            if($admin_points != 0){
                $adminfields = $this->countFields($report_id,$this->admin_role->id);
            }

            $total_points = ($adminfields + count($request->hr_ratings)) * 10 ;
            $avg = ($ratings / $total_points) * 100;

            $pfmr->where('id',$report_id)
                ->update([
                    'avg_points'  => $avg,
                    'hr_points'  => $points     
                ]);

        }
        
    }

    public function updateHrInfo(Request $request,$id){
     
        if($request->hr_ratings){
            
            foreach($request->hr_ratings as $key => $rating){
                $request->validate([
                    'hr_ratings.'.$key => 'required',
                ]);
            }

            $ratings = 0;
            $points = [];
    
            $pfmreport = new Report;
            $pfmreport = $pfmreport->where('id',$id)->update([ 'hr_remarks' => $request->hr_remarks ]);
            // $hr_points = $pfmreport->where('id',$id)->pluck('hr_points');
        
            foreach($request->hr_ratings as $key => $rating){
                // $points += $rating;
                $ratings += $rating;
                $this->updateFieldValues($id,$key,$rating,$this->hr_role->id);
            }

            $this->updateAvg($id,$request,$ratings);

            return redirect()->route('report.index')->with('success','Report has been updated successfully.');
        }
    }

    public function countFields($report_id,$role_id){

        $pfm_report = Report::where('id',$report_id)->first();

        if($pfm_report->ratingValue){
            $desgid = null;
            
            if($pfm_report->user && $pfm_report->user->empDesg){
                $desgid = $pfm_report->user->empDesg->id;
            }

            if($role_id == $this->admin_role->id){
                return Field::where('role_id',$role_id)
                                    ->where('status',1)
                                    ->whereIn('designation_id',[$desgid])
                                    ->count();
            }

            if($role_id == $this->hr_role->id){
                return Field::where('role_id',$role_id)
                                ->where('status',1)
                                ->whereIn('designation_id',[$desgid])
                                ->count();
            }
        }
    }
    /**
     * Show the form for editing the specified resource.
     *  
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin_fields = [];
        $hrField = [];
        $year = null;

        $pfmreport = Report::findOrFail($id);

        $emp = User::join('model_has_roles as r','users.id','=','r.model_id')->select('users.*', 'r.role_id')->whereNotNull('users.emp_id')->where('r.role_id', '!=', Auth::user()->roles[0]->id)->where('users.id',$pfmreport->user_id)->first();

        if(!$emp){
            return redirect()->back();
        }

        $allFields = Field::all();
 
        if($pfmreport->ratingValue){
            foreach($allFields as $field){
                $rating = $this->getFieldValue($id,$field->id);
            
                // dd($rating);
                if($field->role_id == $this->admin_role->id && $field->status == 1 && in_array($emp->designation_id,explode(',',$field->designation_id))){
                   $admin_fields[] = [
                                    'id'  => $field->id,
                                    'name' => $field->name,
                                    'value' => $rating || $rating != null ? $rating->field_value : 0
                                    ];  
                }

                if($field->role_id == $this->hr_role->id && $field->status == 1 && in_array($emp->desigantion_id,explode(',',$field->designation_id))){
                    $hrField[] = [
                                    'id'  => $field->id,
                                    'name' => $field->name,
                                    'value' => $rating || $rating != null ? $rating->field_value : 0
                                    ];  
                }
            }
        }

        $deduction_points = count($admin_fields)*10;

        if(auth()->user()->roles[0]->id == $this->admin_role->id){
            return view('report.rating_form.admin_fields',compact('pfmreport','admin_fields','emp','deduction_points'));
        }

        if(auth()->user()->roles[0]->id == $this->hr_role->id){
            return view('report.rating_form.hr_fields',compact('pfmreport','emp','hrField'));
        }
        
    }

    public function getFieldValue($pfm_id,$rating_id){
        return FieldValue::where('report_id',$pfm_id)->where('field_id',$rating_id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $ratings = 0;
        $pfmreport = Report::where('id',$id)->first();
        $admin_points = Report::where('id',$id)->pluck('admin_points'); 
        
        if($request->admin_ratings && $pfmreport){

            foreach($request->admin_ratings as $key => $rating){
                $request->validate([
                    'admin_ratings.'.$key => 'required'
                ]);
            }

            Report::where('id',$id)->update([
                'admin_deduct_points' => $request->deduct_points ?: 0,
                'admin_remarks'  => $request->admin_remarks
            ]);

            foreach($request->admin_ratings as $key => $rating){
                $ratings += $rating;
                $this->updateFieldValues($id,$key,$rating,$this->admin_role->id);
            }

            $this->updateAvg($id,$request,$ratings);

            return redirect()->route('report.index')->with('success','Report updated successfully');
        }
    }

    public function updateFieldValues($pfmid,$key,$value,$role_id){
        $field = FieldValue::where('report_id',$pfmid)->where('field_id',$key)->first();

        if($field){
            $field->update(['field_value' => $value]);
        }else{
            FieldValue::create([
                'report_id' => $pfmid,
                'field_id' => $key,
                'field_value' => $value,
                'role_id'  => $role_id
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FieldValue::where('report_id',$id)->delete();
        Report::where('id',$id)->delete();

        return redirect()->route('report.index')->with('success','Report Deleted Successfully');
    }
}
