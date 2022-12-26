<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\BuildingDetailFile;
use App\Models\BuildingSale;
use App\Models\User;
use App\Models\EmailHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use PharIo\Manifest\Email;

class EmailController extends Controller
{
    public function email_compose()
    {
        return view('user.email.compose');
    }

    public function email_compose_send(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'subject' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with($this->message($validator->errors()->first(), 'error'));
        }
        $data = [];
        $data['subject'] = $request->subject;
        $data['body'] = $request->body;
        if($request->email != 'both' && $request->email != 'clients' && $request->email != 'leads'){
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with($this->message($validator->errors()->first(), 'danger'));
            }
            $data['emails'] = [$request->email];
        }
        else{
            $users = get_user_by_projects();
            $lead = get_leads_from_user($users)->whereNot('status', 'lost')->whereNot('status', 'mature')->pluck('email')->toArray();
            $client = get_clients_from_user($users)->pluck('email')->toArray();
            $both = array_merge($lead,$client);

            if($request->email == 'leads'){
                $email_arr = $lead;
            }
            elseif($request->email == 'clients'){
                $email_arr = $client;
            }
            elseif($request->email == 'both'){
                $email_arr = $both;
            }
            else{
                $email_arr = [];
            }
            $data['emails'] = $email_arr;
        }
        if(isset($request->id) && $request->id !== null){
            $email_history = EmailHistory::findOrFail($request->id);
            $old_images = explode(',',$email_history->images);
        }else{
            $old_images = [];
        }
        if(isset($request->images)){
            $images = $request->images;
            foreach($images as $img){
                $name = time().'-'.rand().'.'.$img->getClientOriginalExtension();
                $path = 'mail-media/images';
                $img->move(public_path($path),$name);
                $new_images[] = $path."/".$name;
            }
        }
        else{
            $new_images = [];
        }
        $data['image'] = array_merge($new_images,$old_images);
        try {
            foreach($data['emails'] as $email){
                $data['email'] = $email;
                Mail::send('user.email.email_template', $data, function($message) use($data) {
                    $message->to($data['email'])->subject($data['subject']);
                });
                if (!Mail::failures()) {
                    $email_history = new EmailHistory();
                    $email_history->send_by = Auth::user()->id;
                    $email_history->to = $email;
                    $email_history->subject = $data['subject'];
                    $email_history->body = $data['body'];
                    $email_history->images = implode(',',$data['image']);
                    $email_history->status = 'sent';
                    $email_history->date = date('Y-m-d H:i:s');
                    $email_history->save();
                }
            }
            if(isset($request->id) && $request->id !== null){
                EmailHistory::findOrFail($request->id)->delete();
            }

            return redirect()->route('email.compose',RolePrefix())->with($this->message('Email Sent Successfully', 'success'));
        }
        catch(Exception $e) {
            return redirect()->back()->with($this->message('Email Sent Error', 'danger'));
        }
    }
    public function send_email()
    {
        $email_histories = EmailHistory::where(['send_by'=>Auth::user()->id,'status'=>'sent'])->get();
        return view('user.email.sent',compact('email_histories'));
    }
    public function email_destroy($id)
    {
        $email_history = EmailHistory::findOrFail($id);
        $email_history->delete();
        if($email_history){
            return response()->json(['status' => 'success', 'message' =>  'Email Delete Successfully']);
        } else{
            return response()->json(['status' => 'error', 'message' =>  'Email Delete Error']);
        }
    }

    public function email_forward(Request $request,$id)
    {
        $mail = EmailHistory::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with($this->message($validator->errors()->first(), 'danger'));
        }
        $data['subject'] = $mail->subject;
        $data['body'] = $mail->body;
        if($mail->images !== null){
            if(str_contains($mail->images,',')){
                $data['image'] = explode(',',$mail->images);
            }else{
                $data['image'] = [$mail->images];
            }
        }else{
            $data['image'] = [];
        }
        if($request->email != 'both' && $request->email != 'clients' && $request->email != 'leads'){
            $validator = Validator::make($request->all(), [
                'email' => 'email',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with($this->message($validator->errors()->first(), 'danger'));
            }
            $data['emails'] = [$request->email];
        }
        else{
            $users = get_user_by_projects();
            $lead = get_leads_from_user($users)->whereNot('status', 'lost')->whereNot('status', 'mature')->pluck('email')->toArray();
            $client = get_clients_from_user($users)->pluck('email')->toArray();
            $both = array_merge($lead,$client);

            if($request->email == 'leads'){
                $email_arr = $lead;
            }
            elseif($request->email == 'clients'){
                $email_arr = $client;
            }
            elseif($request->email == 'both'){
                $email_arr = $both;
            }
            else{
                $email_arr = [];
            }
            $data['emails'] = $email_arr;
        }
        try {
            foreach($data['emails'] as $email){
                $data['email'] = $email;
                Mail::send('user.email.email_template', $data, function($message) use($data) {
                    $message->to($data['email'])->subject($data['subject']);
                });
                if (!Mail::failures()) {
                    $email_history = new EmailHistory();
                    $email_history->send_by = Auth::user()->id;
                    $email_history->to = $email;
                    $email_history->subject = $data['subject'];
                    $email_history->body = $data['body'];
                    $email_history->images = implode(',',$data['image']);
                    $email_history->status = 'sent';
                    $email_history->date = date('Y-m-d H:i:s');
                    $email_history->save();
                }
            }
			if($mail->status == 'draft'){
                $mail->delete();
            }
            return redirect()->route('email.sent',RolePrefix())->with($this->message('Email Sent Successfully', 'success'));
        }
        catch(Exception $e) {
            return redirect()->back()->with($this->message('Email Sent Error', 'danger'));
        }
    }
    public function email_detail($id)
    {
        $email = EmailHistory::findOrFail($id);
        return view('user.email.detail',compact('email'));
    }

    public function email_view($id)
    {
        $email = EmailHistory::findOrFail($id);
        return view('user.email.compose_draft',compact('email'));
    }

    public function draft_email()
    {
        $email_histories = EmailHistory::where(['send_by'=>Auth::user()->id,'status'=>'draft'])->get();
        return view('user.email.draft',compact('email_histories'));
    }

    public function email_compose_save(Request $request)
    {
        if(isset($request->id) && $request->id !== null){
            $email_history = EmailHistory::findOrFail($request->id);
            $old_images = explode(',',$email_history->images);
        }else{
            $email_history = new EmailHistory();
            $old_images = [];
        }
        if(isset($request->images)){
            $images = $request->images;
            foreach($images as $img){
                $name = time().'-'.rand().'.'.$img->getClientOriginalExtension();
                $path = 'mail-media/images';
                $img->move(public_path($path),$name);
                $new_images[] = $path."/".$name;
            }
        }
        else{
            $new_images = [];
        }
        $images = array_merge($new_images,$old_images);
        $email_history->send_by = Auth::user()->id;
        $email_history->to = $request->email;
        $email_history->subject = $request->subject;
        $email_history->body = $request->body;
        $email_history->images = implode(',',$images);
        $email_history->status = 'draft';
        $email_history->date = date('Y-m-d H:i:s');
        $email_history->save();
        return redirect()->route('email.draft',RolePrefix())->with($this->message('Email Saved', 'success'));
    }

    public function remove_image_email(Request $request)
    {
        if(file_exists($request->image)){
            unlink($request->image);
        }
        $email = EmailHistory::findorFail($request->id);
        $images = explode(',',$email->images);
        $a = array_diff($images,[$request->image]);
        if(count($a) === 0){
            $email->images = null;
        }else{
            $email->images = $a;
        }
        $email->save();
        return true;
    }
    public function email_resend(Request $request,$id)
    {
        $email = EmailHistory::findOrFail($id);
        $data['email'] = $email->to;
        $data['body'] = $email->body;
        $data['subject'] = $email->subject;
        if($email->images){
            if(str_contains($email->images,',')){
                $data['image'] = explode(',',$email->images);
            }else{
                $data['image'] = [$email->images];
            }
        }else{
            $data['image'] = null;
        }
        Mail::send('email.email_template', $data, function($message) use($data) {
            $message->to($data['email'])->subject($data['subject']);
        });
        if (!Mail::failures()) {
            $email_history = new EmailHistory();
            $email_history->send_by = $email->send_by;
            $email_history->subject = $email->subject;
            $email_history->body = $email->body;
            $email_history->images = $email->images;
            $email_history->status = 'sent';
            $email_history->date = date('Y-m-d H:i:s');
            $email_history->save();
            return redirect()->route('email.sent',RolePrefix())->with($this->message('Email Sent Successfully', 'success'));
        }
        else{
            return redirect()->back()->with($this->message('Email Sent Error', 'danger'));
        }
    }
}
