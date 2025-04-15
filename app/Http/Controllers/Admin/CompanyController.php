<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return response()->json([
            'companies' => Company::all()
        ], 200);
    }

    public function toggleBan($id)
    {
        $company = Company::findOrFail($id);
        $company['is_banned'] = !$company['is_banned'];
        $company->save();
        return response()->json([
            'message' => $company->is_banned ? 'Company banned' : 'Company unbanned'
        ]);
    }
}
