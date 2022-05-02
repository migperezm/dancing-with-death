<?php

namespace App\Http\Controllers;

use App\Models\Appointment as Appointment;
use App\Models\Dancer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{

    public function getAllByDate(Request $request)
    {
        $appointment = DB::table('appointments')->where('appointment_date', $request->id)->get();        
        return $appointment;
    }

    public function postAppointment(Request $request)
    {
        $appointment = new Appointment();

        if ($dancer = DB::table('dancers')->where('email', $request->email)->first()) {

            if ($prevAppointment = DB::table('appointments')->where('dancer_id', $dancer->id)->where('appointment_date', $request->date)->first()) {                
                return 2;
            }

            $appointment->appointment_date = $request->date;
            $appointment->appointment_time = $request->time;
            $appointment->dancer_id = $dancer->id;

            $appointment->save();
            return $appointment;
        } else {
            //Registramos el bailarin (solo con el mail) si no existe
            $dancer = new Dancer();
            $dancer->name = $request->email;
            $dancer->email = $request->email;
            $dancer->save();

            $appointment->appointment_date = $request->date;
            $appointment->appointment_time = $request->time;
            $appointment->dancer_id = $dancer->id;
            $appointment->save();
        }
    }
    
    public function getAppointmentById(Request $request)
    {
        $Appointment = Appointment::findOrFail($request->id);
        return $Appointment;
    }

    // public function update(Request $request)
    // {
    //     $email = $request->email;
    //     $Appointment = Appointment::findOrFail($request->id);

    //     $Appointment->appointment_date = $request->appointment_date;
    //     $Appointment->dancer_id = $request->dancer_id;

    //     $Appointment->update();

    //     return $Appointment;
    // }

    // public function destroy(Request $request)
    // {
    //     $Appointment = Appointment::destroy($request->id);
    //     return $Appointment;
    // }
}
