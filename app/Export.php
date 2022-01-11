<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    protected $fillable = [
        'repository_send_id','repository_recieve_id','user_sender_id','user_reciever_id','code','total_price','status','daily_report_check','monthly_report_check','note',
    ];
    //
    public function repository_sender(){ 
        return $this->belongsTo(Repository::class,'repository_send_id');
    }
    public function repository_reciever(){ 
        return $this->belongsTo(Repository::class,'repository_recieve_id');
    }
    public function user_sender(){ 
        return $this->belongsTo(User::class,'user_sender_id');
    }
    public function user_reciever(){ 
        return $this->belongsTo(User::class,'user_reciever_id');
    }
    public function exportRecords(){
        return $this->hasMany(ExportRecord::class);
    }
}
