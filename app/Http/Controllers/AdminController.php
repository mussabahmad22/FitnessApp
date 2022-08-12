<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Equipment;
use App\Models\Clas;
use App\Models\User;
use App\Models\Licence;
use App\Models\AddMultipleEqp;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BookingExport;
use App\Models\MultipleEmail;
use App\Models\Booking;
use App\Models\Rating;
use App\Models\SplashVideo;
use App\Models\QR;
use App\Models\Category;


use Illuminate\Http\Request;
use Monolog\Handler\NullHandler;

class AdminController extends Controller
{


    public function index()
    {
        return view('admin.index');
    }

    // ================================== User Controller ===============================
    public function users()
    {
        $users =  User::where('role', 'user')->get();
        return view('admin.index', compact('users'));
    } 

    public function show_user_form()
    {
        $url = url('add_users');
        $title = 'Add User';
        $multiple_emails = [];
        $text = 'Save';

        return view('admin.add_users', ['multiple_emails' => $multiple_emails, 'url' => $url, 'title' => $title, 'text' => $text]);
    }

    public function add_users(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'moreFields.*' => 'required'
        ]);

        $users = new User();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $users->save();

        $emails = $request->moreFields;

        foreach ($emails as $value) {

            $email = new MultipleEmail();
            $email->user_id = $users->id;
            $email->multiple_emails = $value;
            $email->save();
        }

        return redirect(route('users', compact('users')))->with('success', 'User Added successfully');
    }

    public function delete_user(Request $request)
    {
        $user_id = $request->delete_user_id;
        $booking_user = Booking::where('user_id', $user_id);
        $booking_user->delete();
        $multiple_emails = MultipleEmail::where('user_id', $user_id);
        $multiple_emails->delete();
        $ratings = Rating::where('user_id', $user_id);
        $ratings->delete();
        $users = User::findOrFail($user_id);
        $users->delete();
        return redirect(route('users'))->with('error', 'User Deleted successfully');
    }

    public function edit_user($id)
    {

        $record = User::find($id);
        $multiple_emails = MultipleEmail::where("user_id", $record->id)->get();
        $url = url('update_user') . "/" . $id;
        $title = 'Edit User';
        $text = 'Update';
        return view('admin.add_users', ['multiple_emails' => $multiple_emails, 'record' => $record, 'url' => $url, 'title' => $title, 'text' => $text]);
    }
    public function update_user($id, Request $request)
    {

        $email = MultipleEmail::where('user_id', $id);
        $email->delete();


        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'moreFields.*' => 'required'
        ]);

        $users = User::findOrFail($id);
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $users->save();

        $emails = $request->moreFields;
        // dd($emails);

        foreach ($emails as $value) {

            $email = new MultipleEmail();
            $email->user_id = $users->id;
            $email->multiple_emails = $value;
            $email->save();
        }
        return redirect(route('users'))->with('success', 'User Update successfully');
    }

    public function logout()
    {

        Session::flush();
        Auth::logout();
        return redirect('login');
    }

    //================================licence Controller====================================
    public function licence()
    {
        $licences = Licence::all();
        return view('admin.licence', compact('licences'));
    }

    public function add_licence(Request $request)
    {

        $request->validate([
            'licence_id' => 'required|integer|digits:7',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $licence = new Licence();
        $licence->licence_key =  $request->licence_id;
        $licence->start_date_time = $request->start_date;
        $licence->end_date_time = $request->end_date;
        $licence->save();
        return redirect(route('licence'))->with('success', 'Exercise Added successfully');
    }

    public function edit_licence($id)
    {

        $licence = Licence::findOrFail($id);
        return response()->json([
            'status' => '200',
            'licence' => $licence,
        ]);
    }

    public function licence_update(Request $request)
    {

        $request->validate([
            'licence_id' => 'required|integer|digits:7',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $query_id = $request->query_id;

        $licence = Licence::findOrFail($query_id);
        $licence->licence_key =  $request->licence_id;
        $licence->start_date_time = $request->start_date;
        $licence->end_date_time = $request->end_date;
        $licence->save();
        return redirect()->back()->with('success', 'Exercise Updated successfully');
    }

    public function licence_delete(Request $request)
    {


        $query_id = $request->delete_exercise_id;
        $exercise = Licence::findOrFail($query_id);
        $exercise->delete();
        return redirect()->back()->with('error', 'Exercise Deleted successfully');
    }




    //============================ eqpuipments controller ===========================================
    public function eqp()
    {

        $query = Equipment::all();
        return view('admin.eqp', compact('query'));
    }

    public function add_eqp_show()
    {
        $url = url('add_equipments');
        $title = 'Add Equipment';
        $text = 'Save';
        $variable_text = 'disabled';
        return view('admin.add_eqp', ['url' => $url, 'title' => $title, 'text' => $text, 'variable_text' => $variable_text]);
    }

    public function add_eqp(Request $request)
    {

        if ($request->file('file_title') == null) {
            $image_name = "";
        } else {
            $path_title = $request->file('file_title')->store('public/images');

            $image_name = basename($path_title);
        }

        $request->validate([
            'eqp_title' => 'required',
            'file_title' => 'required',
            'eqp_desc' => 'required',
            'video_path' => 'required',
        ]);

        $eqp = new Equipment();
        $eqp->eqp_name = $request->eqp_title;
        $eqp->eqp_img = "images/" . $image_name;
        $eqp->eqp_desc = $request->eqp_desc;
        $eqp->eqp_video_path = "files" . "/" . $request->video_path;
        $eqp->save();
        return redirect(route('equipments'))->with('success', 'Equipment Added successfully');
    }

    public function edit_equipment($id)
    {

        $record = Equipment::find($id);
        $url = url('update_equipment') . "/" . $id;
        $title = 'Edit Equipment';
        $text = 'Update';
        $variable_text = '';
        return view('admin.add_eqp', ['record' => $record, 'url' => $url, 'title' => $title, 'text' => $text, 'variable_text' => $variable_text]);
    }
    public function update_equipment($id, Request $request)
    {

        $request->validate([
            'eqp_title' => 'required',
            'eqp_desc' => 'required',

        ]);

        $eqp = Equipment::findOrFail($id);

        if ($request->file('file_title') == null) {

            $image_name = $eqp->eqp_img;
        } else {
            $path_title = $request->file('file_title')->store('public/images');

            $image_name = "images/" .  basename($path_title);
        }

        if ($request->video_path == null) {
            $video_path = $eqp->eqp_video_path;
        } else {
            $video_path = "files" . "/" . $request->video_path;
        }

        $eqp->eqp_name = $request->eqp_title;
        $eqp->eqp_img = $image_name;
        $eqp->eqp_desc = $request->eqp_desc;
        $eqp->eqp_video_path =  $video_path;
        $eqp->save();
        return redirect(route('equipments'))->with('success', 'Equipment Update successfully');
    }

    public function equipment_delete(Request $request)
    {

        $query_id = $request->delete_equipment_id;
        $class = Clas::where('eqp_id', $query_id);
        $class->delete();
        $add_multiple_eqp_id = AddMultipleEqp::where('eqp_id', $query_id);
        $add_multiple_eqp_id->delete();
        $equip = Equipment::findOrFail($query_id);
        $equip->delete();
        return redirect()->back()->with('error', 'Equipment Deleted successfully');
    }


    //=================================Class Controller ========================================
    public function clas()
    {

        $query = Clas::all();
        return view('admin.class', compact('query'));
    }

    public function add_clas_show()
    {
        $categories = Category::all();
        $eqps = Equipment::all();
        $url = url('add_class');
        $title = 'Add Class';
        $mltp_eqp_array = [];
        $text = 'Save';
        $variable_text = 'disabled';
        return view('admin.add_class', ['categories' => $categories, 'eqps' =>  $eqps, 'url' => $url, 'mltp_eqp_array' =>   $mltp_eqp_array, 'title' => $title, 'text' => $text, 'variable_text' => $variable_text]);
    }

    public function add_clas(Request $request)
    {
        
        if ($request->file('qr_img') == null) {
            $image_qr = "";
        } else {
            $path_title = $request->file('qr_img')->store('public/images');

            $image_qr = basename($path_title);
        }

        if ($request->file('video_thumb_img') == null) {
            $image_thumb = "";
        } else {
            $path_title = $request->file('video_thumb_img')->store('public/images');

            $image_thumb = basename($path_title);
        }

        if ($request->file('file_title') == null) {
            $image_name = "";
        } else {
            $path_title = $request->file('file_title')->store('public/images');

            $image_name = basename($path_title);
        }

        $request->validate([
            'clas_title' => 'required',
            'desc' => 'required',
            'trainer_name' => 'required',
            'workout_level' => 'required',
            'file_title' => 'required',
            'video_thumb_img' => 'required',
            'qr_img' => 'required',
            'video_path' => 'required',
        ]);
        
        $clas = new Clas();
        //$clas->eqp_id = $request->eqp_title_id;
        $clas->cat_id = $request->cat_id;
        $clas->clas_name = $request->clas_title;
        $clas->desc = $request->desc;
        $clas->workout_level = $request->workout_level;
        $clas->trainer_name = $request->trainer_name;
        $clas->clas_img = "images/" . $image_name;
        $clas->video_thumb_img= "images/" . $image_thumb;
        $clas->clas_qr_img = "images/" . $image_qr;
        $clas->clas_video_path = "files" . "/" . $request->video_path;
        $clas->save();

        $eqps = $request->eqp_title_id;
        if (is_null($eqps)) {

            $mltp_eqp = new AddMultipleEqp();
            $mltp_eqp->class_id = $clas->id;
            $mltp_eqp->eqp_id = NULL;
            $mltp_eqp->save();
        } else {
            foreach ($eqps as $eqp) {
                $mltp_eqp = new AddMultipleEqp();
                $mltp_eqp->class_id = $clas->id;
                $mltp_eqp->eqp_id = $eqp;
                $mltp_eqp->save();
            }
        }
        return redirect(route('classes'))->with('success', 'Class Added successfully');
    }

    public function edit_class($id)
    {
        $categories = Category::all();
        $eqps = Equipment::all();
        $record = Clas::find($id);

        $mltp_eqp = AddMultipleEqp::where('class_id', $record->id)->get();
        $mltp_eqp_array = [];
        foreach ($mltp_eqp as $mltp) {
            array_push($mltp_eqp_array, $mltp->eqp_id);
        }

        $url = url('update_class') . "/" . $id;
        $title = 'Edit Class';
        $text = 'Update';
        $variable_text = '';
        return view('admin.add_class', ['categories' => $categories, 'eqps' =>  $eqps, 'mltp_eqp_array' =>   $mltp_eqp_array, 'record' => $record, 'url' => $url, 'title' => $title, 'text' => $text, 'variable_text' => $variable_text]);
    }

    public function update_class($id, Request $request)
    {

        $eqp = AddMultipleEqp::where('class_id', $id);
        $eqp->delete();


        $request->validate([
            'clas_title' => 'required',
            'desc' => 'required',
            'trainer_name' => 'required',
            'workout_level' => 'required',

        ]);

        $class = Clas::findOrFail($id);

        if ($request->file('file_title') == null) {

            $image_name = $class->clas_img;
        } else {
            $path_title = $request->file('file_title')->store('public/images');

            $image_name = "images/" .  basename($path_title);
        }

        if ($request->file('video_thumb_img') == null) {

            $image_thumb = $class->video_thumb_img;

        } else {
            $path_title = $request->file('video_thumb_img')->store('public/images');

            $image_thumb = "images/" . basename($path_title);
        }

        if ($request->file('qr_img') == null) {

            $image_qr = $class->clas_qr_img;

        } else {

            $path_title = $request->file('qr_img')->store('public/images');

            $image_qr = "images/" .  basename($path_title);
        }

        if ($request->video_path == null) {

            $video_path = $class->clas_video_path;

        } else {

            $video_path = "files" . "/" . $request->video_path;
        }

        //$class->eqp_id = $request->eqp_title_id;
        $class->cat_id = $request->cat_id;
        $class->clas_name = $request->clas_title;
        $class->desc = $request->desc;
        $class->workout_level = $request->workout_level;
        $class->trainer_name = $request->trainer_name;
        $class->clas_img =   $image_name;
        $class->video_thumb_img =   $image_thumb;
        $class->clas_qr_img = $image_qr;
        $class->clas_video_path = $video_path;
        $class->save();

        $eqps = $request->eqp_title_id;
        if (is_null($eqps)) {

            $eqp = AddMultipleEqp::where('class_id', $id);
            $eqp->delete();

            $mltp_eqp = new AddMultipleEqp();
            $mltp_eqp->class_id = $class->id;
            $mltp_eqp->eqp_id = NULL;
            $mltp_eqp->save();
        } else {

            $eqp = AddMultipleEqp::where('class_id', $id);
            $eqp->delete();

            foreach ($eqps as $eqp) {
                $mltp_eqp = new AddMultipleEqp();
                $mltp_eqp->class_id = $class->id;
                $mltp_eqp->eqp_id = $eqp;
                $mltp_eqp->save();
            }
        }
        return redirect(route('classes'))->with('success', 'Class Update successfully');
    }

    public function class_delete(Request $request)
    {

        $query_id = $request->delete_class_id;

        $multiple_eqp_delete_class_id = AddMultipleEqp::where('class_id', $query_id);
        $multiple_eqp_delete_class_id->delete();
        $ratings = Rating::where('class_id', $query_id);
        $ratings->delete();
        $booking = Booking::where('class_id', $query_id);
        $booking->delete();
        $cat = Category::where('class_id', $query_id);
        $cat->delete();
        $class = Clas::findOrFail($query_id);
        $class->delete();
        return redirect()->back()->with('error', 'Licence Deleted successfully');
    }

    //============================ Rating & Reviews Controller =========================================

    public function ratings()
    {
        $ratings = Rating::join('clas', 'ratings.class_id', '=', 'clas.id')->join('users', 'ratings.user_id', '=', 'users.id')->select('users.name', 'clas.clas_name', 'ratings.class_review', 'ratings.difficulty_rating', 'ratings.instructor_rating', 'ratings.id')->get();
        return view('admin.ratings', compact('ratings'));
    }

    public function ratings_delete(Request $request)
    {

        $query_id = $request->delete_rating_id;
        $ratings = Rating::findOrFail($query_id);
        $ratings->delete();
        return redirect()->back()->with('error', 'Ratings Deleted successfully');
    }

    public function booking()
    {
        $booking = Booking::all();
        return view('admin.booking', compact('booking'));
    }

    public function get_booking_data()
    {
        return Excel::download(new BookingExport, 'booking_list.xlsx');
    }
    public function booking_delete(Request $request)
    {
        $query_id = $request->delete_booking_id;
        $booking = Booking::findOrFail($query_id);
        $booking->delete();
        return redirect()->back()->with('error', 'Booking Deleted successfully');
    }

    // ==================================Splash Controller=====================================

    public function splashvideo()
    {

        $query = SplashVideo::all();

        $video = SplashVideo::findOrFail(1);

        return view('admin.splash_screen', compact('query','video'));
    }

    public function splashvideoadd(Request $request)
    {

        $video = SplashVideo::findOrFail(1);

        if ($request->file('file_title') == null) {
            $image_name = $video->logo;
        } else {
            $path_title = $request->file('file_title')->store('public/images');

            $image_name = "images/" . basename($path_title);
        }


        if ($request->video_path == null) {

            $video_path = $video->splash_video_path;
        } else {

            $video_path = "files" . "/" . $request->video_path;
        }

        if ($request->logo_text == null) {

            $logo_text = $video->logo_text;
        } else {

            $logo_text = $request->logo_text;
        }

        $video->splash_video_path = $video_path;
        $video->logo =  $image_name;
        $video->logo_text =  $logo_text;
        $video->save();
        return redirect()->back()->with('success', 'video added successfully');
    }

    // ==================================QR Controller=====================================

    public function QR_show()
    {

        $query = QR::all();
        return view('admin.qr', compact('query'));
    }

    public function QR(Request $request)
    {

        $QR = QR::findOrFail(1);

        if ($request->file('file_title') == null) {

            $image_name =  $QR->qr_img;
        } else {

            $path_title = $request->file('file_title')->store('public/images');

            $image_name = "images/" . basename($path_title);
        }


        $QR->qr_img =  $image_name;
        $QR->save();
        return redirect()->back()->with('success', 'QR Image added successfully');
    }

    public function category()
    {
        $category = Category::all();
        return view('admin.category', compact('category'));
    }

    public function add_category(Request $request)
    {
        if ($request->file('file_title') == null) {

            $image_name = "";
        } else {
            $path_title = $request->file('file_title')->store('public/images');

            $image_name = basename($path_title);
        }

        $request->validate([
        
            'cat_title' => 'required',
            'file_title' => 'required',

        ]);

        $cat = new Category();
        $cat->category_title = $request->cat_title;
        $cat->icon_img =  "images/" . $image_name;
        $cat->save();
        return redirect()->back()->with('success', 'Category  added successfully');
    }

    public function edit_category($id)
    {

        $category = Category::findOrFail($id);
        return response()->json([
            'status' => '200',
            'category' => $category,
        ]);
    }

    public function category_update(Request $request)
    {
    
        $request->validate([
            'cat_title' => 'required',
        ]);

        $query_id = $request->query_id;

        $cat = Category::findOrFail($query_id);

        if ($request->file('file_title') == null) {

            $image_name = $cat->icon_img;

        } else {
            
            $path_title = $request->file('file_title')->store('public/images');

            $image_name = "images/" . basename($path_title);
        }

        $cat->category_title = $request->cat_title;
        $cat->icon_img =  $image_name;
        $cat->save();
        return redirect()->back()->with('success', 'Category  added successfully');
    }

    public function category_delete(Request $request)
    {
        $query_id = $request->delete_category_id;
        
        $class = Clas::where('cat_id', $query_id )->first();
        $mtlp_eqp = AddMultipleEqp::where('class_id', $class->id);
        $mtlp_eqp->delete();
        $class->delete();
        $cat = Category::findOrFail($query_id);
        $cat->delete();
        return redirect()->back()->with('error', 'Category Deleted successfully');
    }
}
