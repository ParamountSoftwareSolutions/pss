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
        return view('email.compose');
    }

    public function email_compose_send(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'subject' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with($this->message($validator->errors()->first(), 'danger'));
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
            $data['total'] = 1;
            $data['sent'] = 1;
        }
        else{
            $building = Helpers::building_detail();
            $leads = BuildingSale::where('order_type','lead');
            $clients = BuildingSale::whereIn('building_id', $building->pluck('id')->toArray())->where('order_type','sale');
            if (Auth::user()->roles[0]->name == 'sale_person') {
                $leads->where('user_id', Auth::id());
                $clients->where('user_id', Auth::id());
            }
            $leads = $leads->pluck('customer_id')->toArray();
            $clients = $clients->pluck('customer_id')->toArray();
            $both = array_merge($leads,$clients);

            if($request->email == 'leads'){
                $users = $leads;
            }
            elseif($request->email == 'clients'){
                $users = $clients;
            }
            elseif($request->email == 'both'){
                $users = $both;
            }
            else{
                $users = [];
            }
            $email_list = User::whereIn('id',$users)->pluck('email')->toArray();
            $data['total'] = count($email_list);
            $data['emails'] = array_filter($email_list);
            $data['sent'] = count($data['emails']);
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
                $new_images[] = 'public/'.$path."/".$name;
            }
        }
        else{
            $new_images = [];
        }
        $data['image'] = array_merge($new_images,$old_images);
        try {
            foreach($data['emails'] as $email){
                $data['email'] = $email;
                Mail::send('email.email_template', $data, function($message) use($data) {
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

            return redirect()->route('email.compose',RolePrefix())->with($this->message($data['sent'].' of '.$data['total'].' Email Sent Successfully', 'success'));
        }
        catch(Exception $e) {
            return redirect()->back()->with($this->message('Email Sent Error', 'danger'));
        }
    }
    public function send_email()
    {
        $email_histories = EmailHistory::where(['send_by'=>Auth::user()->id,'status'=>'sent'])->get();
        return view('email.sent',compact('email_histories'));
    }
    public function email_destroy($panel,$id)
    {
        $email_history = EmailHistory::findOrFail($id);
        $email_history->delete();
        if($email_history){
            return response()->json(['status' => 'success', 'message' =>  'Email Delete Successfully']);
        } else{
            return response()->json(['status' => 'error', 'message' =>  'Email Delete Error']);
        }
    }

    public function email_forward(Request $request,$panel,$id)
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
            $data['total'] = 1;
            $data['sent'] = 1;
        }
        else{
            $building = Helpers::building_detail();
            $leads = BuildingSale::where('order_type','lead');
            $clients = BuildingSale::whereIn('building_id', $building->pluck('id')->toArray())->where('order_type','sale');
            if (Auth::user()->roles[0]->name == 'sale_person') {
                $leads->where('user_id', Auth::id());
                $clients->where('user_id', Auth::id());
            }
            $leads = $leads->pluck('id')->toArray();
            $clients = $clients->pluck('customer_id')->toArray();
            $both = array_merge($leads,$clients);

            if($request->email == 'leads'){
                $users = $leads;
            }
            elseif($request->email == 'clients'){
                $users = $clients;
            }
            elseif($request->email == 'both'){
                $users = $both;
            }
            else{
                $users = [];
            }
            $email_list = User::whereIn('id',$users)->pluck('email')->toArray();
            $data['total'] = count($email_list);
            $data['emails'] = array_filter($email_list);
            $data['sent'] = count($data['emails']);
        }
        try {
            foreach($data['emails'] as $email){
                $data['email'] = $email;
                Mail::send('email.email_template', $data, function($message) use($data) {
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
            return redirect()->route('email.send_email',RolePrefix())->with($this->message($data['sent'].' of '.$data['total'].' Email Sent Successfully', 'success'));
        }
        catch(Exception $e) {
            return redirect()->back()->with($this->message('Email Sent Error', 'danger'));
        }
    }
    public function email_detail($panel,$id)
    {
        $email = EmailHistory::findOrFail($id);
        return view('email.detail',compact('email'));
    }

    public function email_view($panel,$id)
    {
        $email = EmailHistory::findOrFail($id);
        return view('email.compose_draft',compact('email'));
    }

    public function draft_email()
    {
        $email_histories = EmailHistory::where(['send_by'=>Auth::user()->id,'status'=>'draft'])->get();
        return view('email.draft',compact('email_histories'));
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
                $new_images[] = 'public/'.$path."/".$name;
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
        return redirect()->route('email.draft_email',RolePrefix())->with($this->message('Email Saved', 'success'));
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
    public function email_resend(Request $request,$panel,$id)
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
//        dd($data);
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
            return redirect()->route('email.send_email',RolePrefix())->with($this->message('Email Sent Successfully', 'success'));
        }
        else{
            return redirect()->back()->with($this->message('Email Sent Error', 'danger'));
        }
    }
}
