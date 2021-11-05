<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Twilio\Rest\Client;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Aadd
    public function generateCode()
    {
        $code = rand(100000, 999999);
  
        UserCode::updateOrCreate([
            'user_id' => auth()->user()->id,
            'code' => $code
        ]);
  
        $receiverNumber = auth()->user()->phone;
        $message = "Your Login OTP code is ". $code;
    
        try {
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $number = getenv("TWILIO_FROM");
    
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $number, 
                'body' => $message]);
    
        } catch (\Exception $e) {
            // 
        }
    }
}

// https://stackoverflow.com/questions/62810078/how-to-solve-npm-warn-optional-skipping-optional-dependency-fsevents1-2-13