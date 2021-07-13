<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyImage;

class CompanyImageController extends Controller
{

    public function store(Request $request, Company $company)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:16384|dimensions:min_width=100,min_height=100',
        ]);

        $imageName = $request->image->hashName();
        $request->image->storeAs('public/logos', $imageName);

        $oldImage = CompanyImage::where('company_id', $company->id)->first();
        if ($oldImage)
        {
            $oldImage->deleteImg();
        }

        $image = CompanyImage::create(['path' => $imageName, 'company_id' => $company->id]);
        $image->save();
        session()->flash('success', 'Logo uploaded!');
        return redirect("/companies/$company->id");
    }
}
