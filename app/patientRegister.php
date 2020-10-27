<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class patientRegister extends Model
{
    public function count()
    {
        $msgs = DB::table('patient_registers')->count();
        return $msgs;
    }
}
