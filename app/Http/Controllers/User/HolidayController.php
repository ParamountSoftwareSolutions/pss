<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Holiday;
use DB;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    // holidays 
    public function holiday()
    {
        $holiday = Holiday::all();
        return view('user.form.holidays',compact('holiday'));
    }
    // save record
    public function saveRecord(Request $request)
    {
        $request->validate([
            'nameHoliday' => 'required|string|max:255',
            'holidayDate' => 'required|string|max:255',
        ]);
        
        DB::beginTransaction();
        try {
            $holiday = new Holiday;
            $holiday->name_holiday = $request->nameHoliday;
            $holiday->date_holiday  = $request->holidayDate;
            $holiday->save();
            
            DB::commit();
            //Toastr::success('Create new holiday successfully :)','Success');
            return redirect()->back();
            
        } catch(\Exception $e) {
            DB::rollback();
            //Toastr::error('Add Holiday fail :)','Error');
            return redirect()->back();
        }
    }
    // update
    public function updateRecord( Request $request)
    {
        DB::beginTransaction();
        try{
            $id           = $request->id;
            $holidayName  = $request->holidayName;
            $holidayDate  = $request->holidayDate;

            $update = [

                'id'           => $id,
                'name_holiday' => $holidayName,
                'date_holiday' => $holidayDate,
            ];

            Holiday::where('id',$request->id)->update($update);
            DB::commit();
            //Toastr::success('Holiday updated successfully :)','Success');
            return redirect()->back();

        }catch(\Exception $e){
            DB::rollback();
            //Toastr::error('Holiday update fail :)','Error');
            return redirect()->back();
        }
    }
}
