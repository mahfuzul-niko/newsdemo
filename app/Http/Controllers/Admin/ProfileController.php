<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){
        return view('admin.profile.index');
    }
    public function feedback(){
        return view('pages.feedback');
    }
    public function storeFeedback(Request $request){
        $feedback =  new Feedback;
        $feedback->user_id = auth()->user()->id;
        $feedback->rating = $request->rating;
        $feedback->message = $request->message;
        $feedback->save();
        return redirect(route('profile.view'))->with('success', 'Feedback Submitted');
    }
    

}
