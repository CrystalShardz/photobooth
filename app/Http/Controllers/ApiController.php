<?php

namespace App\Http\Controllers;

use App\Mail\PhotoMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function email(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'photo' => 'required'
        ]);

        dd($data['photo']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'photo' => 'required'
        ]);


        $filename = time() . '.jpeg';
        $photoData = base64_decode(
            substr($data['photo'],
                strpos($data['photo'], ',') + 1)
        );
        if (Storage::disk('public')->put(
            'gallery/' . $filename,
            $photoData
        )) {
            return response()->json([
                'result' => 'OK'
            ]);
        }
        return response()->json([
            'result'  => 'error',
            'message' => 'Failed to save image locally.'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function gallery()
    {
        return response()->json(
            Storage::disk('public')->files('gallery')
        );
    }

    public function sendEmail(Request $request)
    {
        $lastPhoto = collect(Storage::disk('public')->allFiles('gallery'))
            ->sortBy(function($file) {
                return $file;
            })->last();

        $email = $request->get('email');
        Mail::to($email)
            ->send(new PhotoMessage($lastPhoto));
    }
}
