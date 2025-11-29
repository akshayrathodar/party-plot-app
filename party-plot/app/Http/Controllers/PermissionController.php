<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use function PHPUnit\Framework\isArray;

class PermissionController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware(
            'permission:permission-list|permission-create|permission-edit|permission-delete',
            ['only' => ['index', 'store']]
        );
        $this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Permission::orderBy('id', 'DESC')->get();

        return view('permissions.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
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
            'name' => 'required|string',
            'actions' => 'nullable|array',
            'actions.*' => 'in:create,list,edit,delete',
            'assign_to_admin' => 'boolean',
        ]);

        $baseName = $request->input('name');
        $actions = $request->input('actions');
        $assignToAdmin = $request->boolean('assign_to_admin');

        // Get admin role if needed
        $adminRole = null;
        if ($assignToAdmin) {
            $adminRole = Role::where('name', 'admin')->first();
        }

        if (!$actions) {
            $permissionName = strtolower($baseName);
            // Prevent duplicate permission creation
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            if ($assignToAdmin && $adminRole) {
                $adminRole->givePermissionTo($permission);
            }
        } elseif (isArray($actions)) {
            foreach ($actions as $action) {
                $permissionName = strtolower($baseName . '-' . $action);

                // Prevent duplicate permission creation
                $permission = Permission::firstOrCreate(['name' => $permissionName]);

                // Assign to admin if requested
                if ($assignToAdmin && $adminRole) {
                    $adminRole->givePermissionTo($permission);
                }
            }
        }

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permissions created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::find($id);

        return view('permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);

        return view('permissions.edit', compact('permission'));
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
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->save();

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Permission::find($id)->delete();

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully');
    }
}
