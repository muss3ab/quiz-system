<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\TenantCredentialsMail;

class TenantController extends Controller
{
    public function create()
    {
        return view('tenants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tenants,id',
            'email' => 'required|email',
            'domain' => 'required|string|unique:domains,domain',
        ]);

        // Create the tenant
        $tenant = Tenant::create([
            'id' => $request->name,
        ]);

        // // Create domain for the tenant
        $tenant->domains()->create([
            'domain' => $request->domain,
        ]);

        // Send welcome email with credentials
        Mail::to($request->email)->send(new TenantCredentialsMail([
            'email' => $request->email,
            'domain' => $request->domain,
        ]));

        return redirect()->route('tenant.success')->with('success', 'Tenant created successfully!');
    }
}
