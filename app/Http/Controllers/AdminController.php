<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Equipment;
use App\Models\Clas;
use App\Models\User;
use App\Models\Licence;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

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
        $text = 'Save';
        return view('admin.add_users', ['url' => $url, 'title' => $title, 'text' => $text]);
    }

    public function add_users(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        $users = new User();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $users->save();
        return redirect(route('users', compact('users')))->with('success', 'User Added successfully');
    }

    public function delete_user(Request $request)
    {
        $user_id = $request->delete_user_id;
        $users = User::findOrFail($user_id);
        $users->delete();
        return redirect(route('users'))->with('error', 'User Deleted successfully');
    }

    public function edit_user($id)
    {

        $record = User::find($id);
        $url = url('update_user') . "/" . $id;
        $title = 'Edit User';
        $text = 'Update';
        return view('admin.add_users', ['record' => $record, 'url' => $url, 'title' => $title, 'text' => $text]);
    }
    public function update_user($id, Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $users = User::findOrFail($id);
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $users->save();
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
            'licence_id' => 'required',
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
            'licence_id' => 'required',
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
            $path_title = "";
        } else {
            $path_title = $request->file('file_title')->store('public/images');
        }

        $request->validate([
            'eqp_title' => 'required',
            'file_title' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'eqp_desc' => 'required',
            'video_file' => 'required',
        ]);

        $eqp = new Equipment();
        $eqp->eqp_name = $request->eqp_title;
        $eqp->eqp_img = $path_title;
        $eqp->eqp_desc = $request->eqp_desc;
        $eqp->eqp_video_path =  $request->video_path;
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
            $path_title = $eqp->eqp_img;
        } else {
            $path_title = $request->file('file_title')->store('images');
        }

        if ($request->video_path == null) {
            $video_path = $eqp->eqp_video_path;
        } else {
            $video_path = $request->video_path;
        }

        $eqp->eqp_name = $request->eqp_title;
        $eqp->eqp_img = $path_title;
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
        $eqps = Equipment::all();
        $url = url('add_class');
        $title = 'Add Class';
        $text = 'Save';
        $variable_text = 'disabled';
        return view('admin.add_class', ['eqps' =>  $eqps ,'url' => $url, 'title' => $title, 'text' => $text, 'variable_text' => $variable_text]);
    }

    public function add_clas(Request $request)
    {

        if ($request->file('file_title') == null) {
            $path_title = "";
        } else {
            $path_title = $request->file('file_title')->store('public/images');
        }


        $request->validate([
            'clas_title' => 'required',
            'eqp_title_id' => 'required',
            'video_file' => 'required',
        ]);

        $clas = new Clas();
        $clas->eqp_id = $request->eqp_title_id;
        $clas->clas_name = $request->clas_title;
        $clas->clas_img = $path_title;
        $clas->clas_video_path = $request->video_path;
        $clas->save();
        return redirect(route('classes'))->with('success', 'Class Added successfully');
    }

    public function edit_class($id)
    {
        $eqps = Equipment::all();
        $record = Clas::find($id);
        $url = url('update_class') . "/" . $id;
        $title = 'Edit Class';
        $text = 'Update';
        $variable_text = '';
        return view('admin.add_class', ['eqps' =>  $eqps ,'record' => $record, 'url' => $url, 'title' => $title, 'text' => $text, 'variable_text' => $variable_text]);
    }
    public function update_class($id, Request $request)
    {

        $request->validate([
            'clas_title' => 'required',
            'eqp_title_id' => 'required',
           
        ]);

        $class = Clas::findOrFail($id);
    
        if ($request->file('file_title') == null) {
            $path_title = $class->clas_img;
        } else {
            $path_title = $request->file('file_title')->store('public/images');
        }

        if ($request->video_path == null) {
            $video_path = $class->clas_video_path;
        } else {
            $video_path = $request->video_path;
        }

        $class->eqp_id = $request->eqp_title_id;
        $class->clas_name = $request->clas_title;
        $class->clas_img = $path_title;
        $class->clas_video_path = $video_path;
        $class->save();
        return redirect(route('classes'))->with('success', 'Class Update successfully');
    }

    public function class_delete(Request $request)
    {

        $query_id = $request->delete_class_id;
        $class = Clas::findOrFail($query_id);
        $class->delete();
        return redirect()->back()->with('error', 'Licence Deleted successfully');
    }

    //============================ Rating & Reviews Controller =========================================

    public function ratings(){

        return view('admin.ratings');
    }

    public function reviews(){

        return view('admin.reviews');
    }

}
