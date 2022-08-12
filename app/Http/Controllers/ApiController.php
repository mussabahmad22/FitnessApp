<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Equipment;
use App\Models\AddMultipleEqp;
use App\Models\Booking;
use App\Models\Clas;
use App\Models\Rating;
use App\Mail\FitnessMail;
use App\Mail\RatingsEmail;
use App\Models\MultipleEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\SplashVideo;
use App\Models\QR;
use App\Models\Category;



class ApiController extends Controller
{
    //=============================== User Login Api==========================
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|string|email|max:255',
            'password' => 'required',
        ];

        $validator = FacadesValidator::make($request->all(), $rules);

        if ($validator->fails()) {
            $err = $validator->errors()->getMessages();
            $msg = array_values($err)[0][0];
            $res['status'] = false;
            $res['message'] = $msg;

            return response()->json($res);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {

                $res['status'] = true;
                $res['message'] = "Password Matched! You have Login successfully!";
                $res['User Data'] = User::find($user->id);
                return response()->json($res);
            } else {

                $res['status'] = false;
                $res['message'] = "Password mismatch";
                return response()->json($res);
            }
        } else {

            $res['status'] = false;
            $res['message'] = "User does not exist";
            return response()->json($res);
        }
    }

    //==================================Equipment Details Api =============================
    public function eqp_details()
    {

        $eqp = Equipment::all();

        if (count($eqp) == 0) {

            $res['status'] = false;
            $res['message'] = "Equipment Not Found!";
            return response()->json($res, 404);
        } else {

            $res['status'] = true;
            $res['message'] = "Equipment List";
            $res['data'] = $eqp;
            return response()->json($res);
        }
    }
    //============================Recomended Video Eqp Api=============================
    public function recomended_video(Request $request)
    {

        $recomended_videos = Clas::Select('id', 'clas_name', 'clas_img', 'video_thumb_img' , 'clas_qr_img', 'clas_video_path')->whereIn('id', (AddMultipleEqp::Select('class_id')->where('eqp_id', $request->eqp_id)))->get();

        $class_ratings = [];

        foreach ($recomended_videos as $que) {

            $ratings = Rating::where('user_id', $request->user_id)->where('class_id', $que->id)->first();

            if ($ratings) {

                $que->class_review = $ratings->class_review;
                $que->difficulty_rating = $ratings->difficulty_rating;
                $que->instructor_rating = $ratings->instructor_rating;
            } else {

                $que->class_review = "";
                $que->difficulty_rating = 0;
                $que->instructor_rating = 0;
            }
            array_push($class_ratings, $que);
        }

        if (count($recomended_videos) == 0) {

            $res['status'] = false;
            $res['message'] = "Recomended Videos Not Found!";
            return response()->json($res, 404);
        } else {

            $res['status'] = true;
            $res['message'] = "Recomended Videos In Equipments";
            $res['data'] =   $recomended_videos;
            return response()->json($res);
        }
    }

    //================================== Class Details Api =============================
    public function class_details(Request $request)
    {

        $class = Clas::all();

        $class_ratings = [];

        foreach ($class as $que) {

            $ratings = Rating::where('user_id', $request->user_id)->where('class_id', $que->id)->first();

            if ($ratings) {

                $que->class_review = $ratings->class_review;
                $que->difficulty_rating = $ratings->difficulty_rating;
                $que->instructor_rating = $ratings->instructor_rating;
            } else {

                $que->class_review = "";
                $que->difficulty_rating = 0;
                $que->instructor_rating = 0;
            }
            array_push($class_ratings, $que);
        }


        if (count($class) == 0) {

            $res['status'] = false;
            $res['message'] = "Class Not Found!";
            return response()->json($res, 404);
        } else {

            $res['status'] = true;
            $res['message'] = "Class List";
            $res['data'] = $class_ratings;
            return response()->json($res);
        }
    }

    //================================== Booking Details Api =============================
    public function booking_details(Request $request)
    {

        $user = User::find($request->user_id);
        if (is_null($user)) {

            $res['status'] = false;
            $res['message'] = "User Not Found!";
            return response()->json($res);
        }

        $class = Clas::find($request->class_id);
        if (is_null($class)) {

            $res['status'] = false;
            $res['message'] = "Class Not Found!";
            return response()->json($res);
        }

        $email = Booking::where('user_email', $request->user_email)->first();
        if ($email) {

            $res['status'] = false;
            $res['message'] = "Email Already Exists!";
            return response()->json($res);
        }

        $rules = [
            'class_id' => 'required',
            'user_id' => 'required',
            'user_name' => 'required',
            'user_email' => 'required|string|email|max:255',
            'phone' => 'required',
            'class_type' => 'required'
        ];
        $validator = FacadesValidator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $booking = new Booking();
        $booking->user_id = $request->user_id;
        $booking->class_id = $request->class_id;
        $booking->user_name = $request->user_name;
        $booking->user_email = $request->user_email;
        $booking->phone = $request->phone;
        $booking->class_type = $request->class_type;
        $booking->save();

        $mltp_emails = MultipleEmail::Select('multiple_emails')->where('user_id', $booking->user_id)->get();
        $send_email_data = Booking::where('user_email', $booking->user_email)->first();

        foreach ($mltp_emails as $email) {

            Mail::to($email['multiple_emails'])->send(new \App\Mail\FitnessMail(($send_email_data)));
        };

        if ($booking) {

            $res['status'] = true;
            $res['message'] = "Booking Details Insert Sucessfully Of user!!";
            $res['data'] = $booking;
            return response()->json($res);
        } else {

            $res['status'] = false;
            $res['message'] = "Booking Details Can't Insert Sucessfully!";
            return response()->json($res, 404);
        }
    }

    //================================== Rattings Api =============================
    public function ratings(Request $request)
    {

        $user = User::find($request->user_id);
        if (is_null($user)) {

            $res['status'] = false;
            $res['message'] = "User Not Found!";
            return response()->json($res);
        }

        $class = Clas::find($request->class_id);
        if (is_null($class)) {

            $res['status'] = false;
            $res['message'] = "Class Not Found!";
            return response()->json($res);
        }
        $ratings = Rating::where('user_id', $request->user_id)->where('class_id', $request->class_id)->first();

        if ($ratings) {

            $rating = Rating::find($ratings->id);
            $rating->user_id = $request->user_id;
            $rating->class_id = $request->class_id;
            $rating->class_review = $request->class_review;
            $rating->difficulty_rating = $request->difficulty_rating;
            $rating->instructor_rating = $request->instructor_rating;
            $rating->save();
            $res['status'] = true;
            $res['message'] = "Your Rating Updated of This Class!!";
            $res['data'] = $rating;
            return response()->json($res);
        }


        $rules = [
            'user_id' => 'required',
            'class_id' => 'required',
            'class_review' => 'required',
            'difficulty_rating' => 'required|integer',
            'instructor_rating' => 'required|integer',
        ];
        $validator = FacadesValidator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $rating = new Rating();
        $rating->user_id = $request->user_id;
        $rating->class_id = $request->class_id;
        $rating->class_review = $request->class_review;
        $rating->difficulty_rating = $request->difficulty_rating;
        $rating->instructor_rating = $request->instructor_rating;
        $rating->save();

        $mltp_emails = MultipleEmail::Select('multiple_emails')->where('user_id', $rating->user_id)->get();
        $ratings = Rating::where('user_id', $rating->user_id)->where('class_id', $rating->class_id)->first();
        $name = User::Select('name')->where('id', $rating->user_id)->first();
        $class_name = Clas::Select('clas_name')->where('id', $rating->class_id)->first();

        foreach ($mltp_emails as $email) {

            Mail::to($email['multiple_emails'])->send(new RatingsEmail($ratings, $name,  $class_name));
        };

        if ($rating) {

            $res['status'] = true;
            $res['message'] = "You Have Rate this class Sucessfully!!";
            $res['data'] = $rating;
            return response()->json($res);
        } else {

            $res['status'] = false;
            $res['message'] = "You Can't rate This Class!";
            return response()->json($res, 404);
        }
    }

    public function splashvideo()
    {

        $video = SplashVideo::find(1);
        if (is_null($video)) {

            $res['status'] = false;
            $res['message'] = "Record Not Found!";
            return response()->json($res, 404);
        } else {

            $res['status'] = true;
            $res['message'] = "Splash Screen List";
            $res['data'] = $video;
            return response()->json($res);
        }
    }

    public function qr_image()
    {

        $qr = QR::find(1);

        if (is_null($qr)) {

            $res['status'] = false;
            $res['message'] = "Qr Image Not Found!";
            return response()->json($res, 404);
        } else {

            $res['status'] = true;
            $res['message'] = "Qr Image";
            $res['data'] = $qr;
            return response()->json($res);
        }
    }

    public function category()
    {

        $category = Category::all();

        if (count($category) == 0) {

            $res['status'] = false;
            $res['message'] = "category Not Found!";
            return response()->json($res, 404);
        } else {

            $res['status'] = true;
            $res['message'] = "List";
            $res['data'] = $category;
            return response()->json($res);
        }
    }

    public function category_classes(Request $request)
    {
        
        if ($request->cat_id == 0) {
            $class = Clas::all();

            $class_ratings = [];

            foreach ($class as $que) {

                $ratings = Rating::where('user_id', $request->user_id)->where('class_id', $que->id)->first();

                if ($ratings) {

                    $que->class_review = $ratings->class_review;
                    $que->difficulty_rating = $ratings->difficulty_rating;
                    $que->instructor_rating = $ratings->instructor_rating;
                } else {

                    $que->class_review = "";
                    $que->difficulty_rating = 0;
                    $que->instructor_rating = 0;
                }
                array_push($class_ratings, $que);
            }


            if (count($class) == 0) {

                $res['status'] = false;
                $res['message'] = "Class Not Found!";
                return response()->json($res, 404);
            } else {

                $res['status'] = true;
                $res['message'] = "Class List";
                $res['data'] = $class_ratings;
                return response()->json($res);
            }
        }


        $category = Clas::where('cat_id', $request->cat_id)->get();

        $class_ratings = [];

        foreach ($category as $que) {

            $ratings = Rating::where('user_id', $request->user_id)->where('class_id', $que->id)->first();

            if ($ratings) {

                $que->class_review = $ratings->class_review;
                $que->difficulty_rating = $ratings->difficulty_rating;
                $que->instructor_rating = $ratings->instructor_rating;
            } else {

                $que->class_review = "";
                $que->difficulty_rating = 0;
                $que->instructor_rating = 0;
            }
            array_push($class_ratings, $que);
        }

        if (count($category) == 0) {

            $res['status'] = false;
            $res['message'] = "category Not Found!";
            return response()->json($res, 404);
        } else {

            $res['status'] = true;
            $res['message'] = "List";
            $res['data'] = $class_ratings;
            return response()->json($res);
        }
    }
}
