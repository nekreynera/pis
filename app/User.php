<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name', 'first_name', 'middle_name', 'clinic', 'role', 'profile', 'username', 'theme'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

     public function checkIfIntern(){
        $bools = MedInterns::where('interns_id','=',Auth::id())->exists();
        return $bools;
    }
    public function checkRole()
    {
        switch (Auth::user()->role) {
            case '1': //register
                if (Auth::user()->clinic == 54){
                    return redirect('admittedpatient');
                    break;
                }else{
                    return redirect('patients');
                    break;
                }
               
            case '3': //register
                return redirect('triage');
                break;
            case '8': //admin
            //AMO ADI AN PAG DISABLE HAN MGA IN ACTIVE ACCOUNT.. 31 DAYS KUN WARAY NA HYA MAG LOGIN MA DE-ACTIVATE IA ACCOUNT -CALOY
                $days = 31;
                $date = Carbon::now()->subDays($days)->toDateString();
               $data = User::where('activated','=','Y')
                ->whereDate('updated_at', '<=', $date)->update([
                    'activated' => 'N'
                ]);
                //END DD LA KUTOB TAK CODES
                return redirect('register');
                break;
            case '2': //mss
                return redirect('mss');
                break;
            case '9': //pharmacy
                return redirect('pharmacy?stats=all');
                break;
            case '5': //receptions
                if (Auth::user()->clinic == 62){
                  return redirect('malasakit');
                  break;
                }else{
                  return redirect('receptions');
                  break;
                }
            case '10': //cashier
                return redirect('cashier');
                break;
            case '7': //patientlist
                return redirect('patientlist');
                break;
            case '11': //referral
                return redirect('referral');
                break;
            case '12': //medical
                return redirect('medicalrecord?stats=P');
                break;
            case '4': //clerk
              if (Auth::user()->clinic == 21 || Auth::user()->clinic == 22){
                  return redirect('radiologyHome');
                  break;
              }
              elseif (Auth::user()->clinic == 47) {
                  return redirect('laboratorypatients');
                  break;
              }
              else{
                  return redirect('directrequisition');
                  break;
              }
            case '6': //nurse
                return redirect('pediaQueing');
            default:
                return redirect()->route('loginpage');
                break;
        }
    }


    public static function isActive($id)
    {
        return Cache::has('active_'.$id);
    }
       public function clinics()
    {
        return $this->belongsTo(Clinic::class, 'clinic');
    }

}
