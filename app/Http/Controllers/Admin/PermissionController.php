<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends AdminController
{
    public function getIndex()
    {
        $companies = Company::where('status', 1)->get();

        return view('admin.permissions.index', compact('companies'));
    }

    public function getList(Request $request)
    {
        $list = Company::select(
                'companies.id',
                'companies.name as company_name',
                'companies.email',
                'users.username'
            )
            ->leftJoin('users', function ($join) {
                $join->on('users.company_id', '=', 'companies.id')
                    ->where('users.type', 'employee');
            });

        return \DataTables::of($list)->make(true);
    }
    
    public function getUpdate($id)
    {
        $company = Company::findOrFail($id);

        $user = User::where('company_id', $company->id)
            ->where('type', 'employee')
            ->firstOrFail();

        return view('admin.permissions.update', compact('company', 'user'));
    }

    public function postUpdate(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $user = User::where('company_id', $company->id)
            ->where('type', 'employee')
            ->firstOrFail();

        $user->permissions = json_encode($request->permissions);
        $user->save();

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permissions updated successfully!');
    }
}