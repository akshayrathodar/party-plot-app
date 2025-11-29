<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', [
            'only' => ['index', 'store', 'activeChangeStatus', 'deactiveChangeStatus'],
        ]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::orderBy('id', 'desc')->get();

        return view('users.index', compact('data'));
    }

    public function getUsersData(Request $request)
    {
        // Read value
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length'); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = User::count();
        $totalRecordswithFilter = User::where('name', 'like', '%' . $searchValue . '%')
            ->orWhere('email', 'like', '%' . $searchValue . '%')
            ->count();

        // Fetch records
        $records_data = User::orderBy($columnName, $columnSortOrder)
            ->where('name', 'like', '%' . $searchValue . '%')
            ->orWhere('email', 'like', '%' . $searchValue . '%');
        if ($rowperpage != '-1') {
            $records_data->skip($start)->take($rowperpage);
        }
        $records = $records_data->get();

        $data_arr = [];

        foreach ($records as $record) {
            $id = $record->id;
            $name = $record->name;
            $email = $record->email;
            $roles = '';
            if (!empty($record->getRoleNames())) {
                foreach ($record->getRoleNames() as $val) {
                    $roles .= '<label class="badge badge-dark">' . $val . '</label>';
                }
            }

            $status = '';
            $disabled = 'disabled';

            if (auth()->user()->can('user-edit')) {
                $disabled = '';
            }

            if ($record->status == 1) {
                $status .=
                    '<div class="flex-grow-1 icon-state">
                                <label class="switch" data-table="users">
                                    <input type="checkbox" value="' .
                    $record->id .
                    '" checked  ' .
                    $disabled .
                    '/>
                                    <span class="switch-state"></span>
                                </label>
                            </div>';
            } else {
                $status .=
                    '<div class="flex-grow-1 icon-state">
                                <label class="switch" data-table="users">
                                    <input type="checkbox" value="' .
                    $record->id .
                    '" ' .
                    $disabled .
                    '/>
                                    <span class="switch-state"></span>
                                </label>
                            </div>';
            }

            $action = '<ul class="action">';

            $action .=
                '<li><a class="btn btn-sm btn-info m-1" href="' .
                route('admin.users.show', $record->id) .
                '"><i class="fa fa-eye"></i></a></li>';

            if (auth()->user()->can('user-edit')) {
                $action .=
                    '<li><a class="btn btn-sm btn-success m-1" href="' .
                    route('admin.users.edit', $record->id) .
                    '"><i class="fa fa-edit"></i></a></li>';
            }

            if (auth()->user()->can('user-delete')) {
                $action .=
                    '<form method="post" action="' .
                    route('admin.users.destroy', $record->id) .
                    '" style="display:inline" >';
                $action .= '<input type="hidden" name="_method" value="DELETE">';
                $action .= '<input name="_token" type="hidden" value="' . csrf_token() . '">';
                $action .= '<li>';
                $action .=
                    '<button class="btn btn-sm btn-danger m-1" onclick="return confirm(&quot;Are you sure?&quot;);" type="submit"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                $action .= '</li>';
                $action .= '</form>';
            }

            $action .= '</ul>';

            $data_arr[] = [
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'roles' => $roles,
                'status' => $status,
                'action' => $action,
            ];
        }

        $response = [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecordswithFilter,
            'aaData' => $data_arr,
        ];

        echo json_encode($response);
        exit();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'mobile' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'staff_photo' => 'image|mimes:jpeg,png,jpg',
            'staff_id_proof' => 'required|image|mimes:jpeg,png,jpg',
            'roles' => 'required',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        if ($request->hasFile('staff_photo')) {
            $logo = $request->file('staff_photo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('uploads/staffs'), $logoName);
            $input['staff_photo'] = $logoName;
        }

        if ($request->hasFile('staff_id_proof')) {
            $card = $request->file('staff_id_proof');
            $cardName = time() . '_' . $card->getClientOriginalName();
            $card->move(public_path('uploads/staffs/id_proof'), $cardName);
            $input['staff_id_proof'] = $cardName;
        }

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile' => 'required',
            'address' => 'required',
            'password' => 'nullable|confirmed',
            'staff_photo' => 'nullable|image|mimes:jpeg,png,jpg',
            'staff_id_proof' => 'nullable|image|mimes:jpeg,png,jpg',
            'roles' => 'required',
        ]);

        $user = User::findOrFail($id);
        $input = $request->all();

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }

        if ($request->hasFile('staff_photo')) {
            $photo = $request->file('staff_photo');
            $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();

            $uploadPath = public_path('uploads/staffs');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $photo->move($uploadPath, $photoName);
            $input['staff_photo'] = $photoName;

            // Optionally delete old photo
            if ($user->staff_photo && File::exists($uploadPath . '/' . $user->staff_photo)) {
                File::delete($uploadPath . '/' . $user->staff_photo);
            }
        }

        if ($request->hasFile('staff_id_proof')) {
            $proof = $request->file('staff_id_proof');
            $proofName = uniqid() . '.' . $proof->getClientOriginalExtension();

            $idProofPath = public_path('uploads/staffs/id_proof');
            if (!File::exists($idProofPath)) {
                File::makeDirectory($idProofPath, 0755, true);
            }

            $proof->move($idProofPath, $proofName);
            $input['staff_id_proof'] = $proofName;

            if ($user->staff_id_proof && File::exists($idProofPath . '/' . $user->staff_id_proof)) {
                File::delete($idProofPath . '/' . $user->staff_id_proof);
            }
        }

        $user->update($input);

        FacadesDB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId' => 'required|exists:users,id',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'error', 'message' => $validator->errors()->first()],
                400
            );
        }

        $user = User::find($request->userId);
        $user->status = $request->status;
        $user->save();

        return response()->json(
            ['status' => 'success', 'message' => 'User status updated successfully.'],
            200
        );
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function profileSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username,' . Auth::id(),
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'mobile' => 'required',
            'address' => 'required',
            'password' => 'nullable|same:confirm_password',
            'confirm_password' => 'nullable|same:password',
        ]);

        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->username = $request->username;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->address = $request->address;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('staff_photo')) {
            $uploadPath = public_path('uploads/staffs');

            // Optionally delete old photo
            if ($user->staff_photo && File::exists($uploadPath . '/' . $user->staff_photo)) {
                File::delete($uploadPath . '/' . $user->staff_photo);
            }

            $photo = $request->file('staff_photo');
            $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $photo->move($uploadPath, $photoName);
            $user->staff_photo = $photoName;
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile Update Successfully.');
    }

    public function forgetpasswordsubmit(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|required_with:confirm_password|same:confirm_password',
        ]);
        $user = User::find(Auth::id());
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()
                ->route('profile')
                ->with('success', 'Password change successfully.');
        } else {
            return redirect()
                ->back()
                ->withErrors(['msg' => 'Old Password Not Match.']);
        }
    }
}
