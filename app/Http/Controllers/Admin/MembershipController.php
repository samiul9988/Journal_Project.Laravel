<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\membership;
use App\Models\User;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function Showmembership()
    {
        return view('admin.membership.createmember');
    }
    public function membership()
    {
        $this->validate(request(),[
            'name'=>'required'

        ]);
        membership::create([
          'name'=>request('name'),
          'mobile'=>request('mobile'),
          'email'=>request('email'),
          'company'=>request('company'),
          'profession'=>request('profession'),
          'designation'=>request('designation'),
          'gender'=>request('gender'),
          'dob'=>request('dob'),

        ]);
        return redirect()->back();
    }
    public function Allmembers(){
        $allmembers=membership::all();
        return view('admin.membership.Allmembers',compact('allmembers'));
    }
    public function details($id){
        $memberdetails = membership::find($id);
        return view('admin.membership.membersdetails',compact('memberdetails'));
    }
    public function CreateUser($id){
         $member = membership::find($id);
         $createUser = User::create([
            'name'      =>  $member->name,
            'email'     =>  $member->email,
            'password'  => '4444'
         ]);

         $member->user_id = $createUser->id;
         $member->save();
         return redirect()->back();
    }

}
