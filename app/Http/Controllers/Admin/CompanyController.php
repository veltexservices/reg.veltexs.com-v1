<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Company;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends AdminController
{
    public function getIndex(Request $request)
    {
        return view('admin.companies.index');
    }

    public function getList(Request $request)
    {
        $list = Company::select(
                'companies.*',
                'users.username',
                'users.type'
            )
            ->leftJoin('users', function ($join) {
                $join->on('users.company_id', '=', 'companies.id')
                    ->where('users.type', 'employee');
            })
            ->when($request->company_id, function ($q) use ($request) {
                $q->where('companies.id', $request->company_id);
            })
            ->when($request->status !== null && $request->status !== '', function ($q) use ($request) {
                $q->where('companies.status', $request->status);
            })
            ->orderByDesc('companies.updated_at');

        return \DataTables::of($list)

            ->addColumn('company_name', function ($row) {

                return '[ <b>' . e($row->username) . '</b> ]<br>' . e($row->name);

            })

            ->addColumn('contact', function ($row) {

                return e($row->email) . '<br>' . e($row->mobile);

            })

            ->addColumn('website', function ($row) {

                return $row->website ?: '-';

            })

            ->rawColumns([
                'company_name',
                'contact',
            ])

            ->make(true);
    }

    public function getCreate(Request $request)
    {
        $roles = \App\Models\Role::where('name', 'Employee')->get();

        return view('admin.companies.create', compact('roles'));
    }

    public function postCreate(Request $request)
    {
        $validator = \Validator::make($request->all(), [

            // Company Details
            'name'      => 'required|string|max:255',
            'email'     => 'nullable|email|unique:companies,email',
            'mobile'    => 'nullable|digits:10|unique:companies,mobile',
            'website'   => 'nullable|max:255',
            'address'   => 'nullable|string',
            'city'      => 'nullable|string|max:100',
            'state'     => 'nullable|string|max:100',
            'country'   => 'nullable|string|max:100',
            'pincode'   => 'nullable|string|max:20',
            'logo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            // Login Details
            'username'  => 'required|string|max:100|unique:users,username',
            'password'  => 'required|min:6|confirmed',

            'status'    => 'nullable|in:0,1',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);

        }

        \DB::beginTransaction();

        try {

            $employeeRole = \App\Models\Role::where('name', 'Employee')->first();

            if (!$employeeRole) {

                throw new \Exception('Employee role not found.');

            }

            /*
            |--------------------------------------------------------------------------
            | Company Create
            |--------------------------------------------------------------------------
            */

            $company = new \App\Models\Company();

            $company->code = 'CMP' . str_pad(
                Company::withTrashed()->count() + 1,
                5,
                '0',
                STR_PAD_LEFT
            );
            $company->name = $request->name;
            $company->email = strtolower($request->email);
            $company->mobile = $request->mobile;
            $company->website = $request->website;
            $company->address = $request->address;
            $company->city = $request->city;
            $company->state = $request->state;
            $company->country = $request->country ?: 'India';
            $company->pincode = $request->pincode;
            $company->status = $request->status ?? 1;

            if ($request->hasFile('logo')) {

                $company->logo = uploadFile(
                    'logo',
                    300,
                    300,
                    'company'
                );

            }

            $company->save();

            /*
            |--------------------------------------------------------------------------
            | Login User Create
            |--------------------------------------------------------------------------
            */

            $user = new \App\Models\User();

            $user->company_id = $company->id;
            $user->type = 'employee';
            $user->role_id = $employeeRole->id;

            $user->name = $company->name;
            $user->username = strtolower($request->username);
            $user->email = strtolower($request->email);
            $user->mobile = $request->mobile;

            $user->password = bcrypt($request->password);

            $user->status = $request->status ?? 1;

            $user->save();

            \DB::commit();

            return response()->json([
                'message' => 'Company created successfully.',
            ]);

        } catch (\Throwable $th) {

            \DB::rollBack();

            \Log::error($th);

            return response()->json([
                'message' => $th->getMessage(),
            ], 500);

        }
    }

    public function getUpdate(Request $request)
    {
        $company = Company::findOrFail($request->id);

        $user = User::where('company_id', $company->id)
            ->where('type', 'employee')
            ->first();

        return view('admin.companies.update', compact('company', 'user'));
    }

    public function postUpdate(Request $request)
    {
        $company = Company::findOrFail($request->id);

        $user = User::where('company_id', $company->id)
            ->where('type', 'employee')
            ->firstOrFail();

        $validator = \Validator::make($request->all(), [

            // Company
            'name'      => 'required|string|max:255',
            'email'     => "nullable|email|unique:companies,email,{$company->id}",
            'mobile'    => "nullable|digits:10|unique:companies,mobile,{$company->id}",
            'website'   => 'nullable|max:255',
            'address'   => 'nullable|string',
            'city'      => 'nullable|max:100',
            'state'     => 'nullable|max:100',
            'country'   => 'nullable|max:100',
            'pincode'   => 'nullable|max:20',
            'logo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            // Login
            'username'  => "required|unique:users,username,{$user->id}",
            'password'  => 'nullable|min:6|confirmed',

            'status'    => 'nullable|in:0,1',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);

        }

        \DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Update Company
            |--------------------------------------------------------------------------
            */

            $company->name = $request->name;
            $company->email = strtolower($request->email);
            $company->mobile = $request->mobile;
            $company->website = $request->website;
            $company->address = $request->address;
            $company->city = $request->city;
            $company->state = $request->state;
            $company->country = $request->country;
            $company->pincode = $request->pincode;
            $company->status = $request->status ?? 1;

            if ($request->hasFile('logo')) {

                $company->logo = uploadFile(
                    'logo',
                    300,
                    300,
                    'company',
                    $company->logo
                );

            }

            $company->save();

            /*
            |--------------------------------------------------------------------------
            | Update Login User
            |--------------------------------------------------------------------------
            */

            $user->name = $request->name;
            $user->email = strtolower($request->email);
            $user->mobile = $request->mobile;
            $user->username = strtolower($request->username);
            $user->status = $request->status ?? 1;

            if ($request->filled('password')) {

                $user->password = bcrypt($request->password);

            }

            $user->save();

            \DB::commit();

            return response()->json([
                'message' => 'Company updated successfully.',
            ]);

        } catch (\Throwable $th) {

            \DB::rollBack();

            \Log::error($th);

            return response()->json([
                'message' => 'Failed to process your request.',
            ], 500);

        }
    }

    public function getDelete(Request $request)
    {
        \DB::beginTransaction();

        try {

            $company = Company::findOrFail($request->id);

            $user = User::where('company_id', $company->id)
                ->where('type', 'employee')
                ->first();

            if ($user) {

                $user->delete();

            }

            $company->delete();

            \DB::commit();

            return response()->json([
                'message' => 'Company deleted successfully.',
            ]);

        } catch (\Throwable $th) {

            \DB::rollBack();

            \Log::error($th);

            return response()->json([
                'message' => 'Failed to process your request.',
            ], 500);

        }
    }

    public function getChangeStatus(Request $request)
    {
        $company = \App\Models\Company::findOrFail($request->id);
        if (! blank($company)) {
            $company->status = (int) ! $company->status;
            $company->save();
        }

        return response()->json(['message' => 'Your request processed successfully.']);
    }
}