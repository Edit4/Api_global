<?php

namespace App\Http\Controllers;
use GuzzleHttp\Psr7\Response;
use Illuminate\Mail\Mailables\Attachment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class MailController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Attachment[]
     */
    public function sendFeedback(Request $request)
    {
        $data = [
            'fio'=> $request->fio,
            'email'=>$request->email,
            'company'=> $request->company,
            'phone'=> $request->phone
        ];
        $rules=['fio'=>'required',
            'email'=>'required|email',
            'company'=>'required|max:450',
            'phone'=>'required|max:11',
            ];

        $validator =$this->validate($request,$rules);

        if ($validator){


        Mail::send( 'mailFeedback',$data,function ($message) use($data) {
            $message->from('Arion3232@outlook.com');
            $message->to('Arion3232@outlook.com')->subject('заявка');
            $message->to('Arion23232@gmail.com')->subject('заявка');


        });

        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Attachment[]
     */
    public function sendVacancy(Request $request)
    {
        $data = [
            'fio'=> $request->fio,
            'email'=>$request->email,
            'comments'=> $request->comments,
            'phone'=> $request->phone,
            'files'=>$files = $request->file('files')];

        $rules=['fio'=>'required',
            'email'=>'required|email',
            'comments'=>'required|max:450',
            'phone'=>'required|max:11',
            'files'=>'required|mimes:doc,docx,pdf,zip,rar,txt|max:500000'];

        $validator =$this->validate($request,$rules);

        if ($validator)
        {
            Mail::send( 'mailVacancy',$data,function ($message) use($files,$data) {
                $message->from('Arion3232@outlook.com');
                $message->to('Arion3232@outlook.com')->subject('заявка');
                $message->to('Arion23232@gmail.com')->subject('заявка');
                $message->attach($files->getRealPath(), [
                    'as' => $files->getClientOriginalName(),
                    'mime' => $files->getMimeType()
                ]);
            });
        }
     }
}
