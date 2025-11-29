<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function getDataById(Request $request)
    {
        $table = $request->table;
        $id = $request->id;

        try {
            $sql = DB::table($table)->where('id', $id)->first();
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }

        return response()->json($sql, 200);
    }

    public function getDataByCondition(Request $request)
    {
        $table = $request->table;
        $condition = json_decode($request->where, true);

        try {
            $data = DB::table($table)->where($condition)->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }

        return response()->json(['error' => 'Something Went Wrong'], 400);
    }

    public function mediaDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'type' => 'required',
            'table' => 'required',
            'column' => 'required',
            'path' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 404);
        }

        if (isset($request->id) && isset($request->type)) {
            $id = $request->id;
            $model = $request->table;
            $column = $request->column;
            $path = $request->path . '/';

            $sql = DB::table($model)->where('id', $id);

            $data = $sql->first();
            
            if (isset($data->$column)) {
                if ($request->type == 'multiple-image') {
                    if (!empty($data->$column)) {
                        $imageArray = json_decode($data->$column, true);

                        if (
                            isset($imageArray[$request->arrayKey]) &&
                            file_exists(public_path($path . $imageArray[$request->arrayKey]))
                        ) {
                            unlink(public_path($path . $imageArray[$request->arrayKey]));
                        }
                        $imageArray[$request->arrayKey] = null;
                        unset($imageArray[$request->arrayKey]);

                        $newImgData = json_encode($imageArray);
                    }
                } elseif ($request->type == 'multiple-dimensional-image') {
                    if (!empty($data->$column)) {
                        $imageArray = json_decode($data->$column, true);

                        if (
                            isset($imageArray[$request->arrayKey][$request->key]) &&
                            file_exists(
                                public_path($path . $imageArray[$request->arrayKey][$request->key])
                            )
                        ) {
                            unlink(
                                public_path($path . $imageArray[$request->arrayKey][$request->key])
                            );
                        }
                        unset($imageArray[$request->arrayKey][$request->key]);

                        $newImgData = json_encode($imageArray);
                    }
                } else {
                    if (isset($data->$column) && file_exists(public_path($path . $data->$column))) {
                        unlink(public_path($path . $data->$column));
                    }
                    $newImgData = null;
                }

                $sql->update([$column => $newImgData]);

                return response()->json(['success' => 'Document Deleted Successfully'], 200);
            }
        }

        return response()->json(['error' => 'Something Went Wrong'], 400);
    }

    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'table' => 'required',
            'id' => 'required',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'error', 'message' => $validator->errors()->first()],
                400
            );
        }

        $model = DB::table($request->table)->where('id', $request->id);

        if (!empty($model->first())) {
            $model->update(['status' => $request->status]);
            return response()->json(
                ['status' => 'success', 'message' => 'Status updated successfully.'],
                200
            );
        }

        return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 404);
    }

    
}
