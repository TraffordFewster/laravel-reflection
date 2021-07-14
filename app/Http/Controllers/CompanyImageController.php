<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cache;

class CompanyImageController extends Controller
{

    public function view(Company $company)
    {
        $cacheKey = "$company->id logo_cache";
        if (Cache::get($cacheKey))
        {
            return Cache::get($cacheKey);
        } else {
            $path = storage_path("app\public\logos\\" . $company->logo);
            if (!File::exists($path)) {
                abort(404);
            }

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            $response->header("Cache-Control", "max-age=300");

            Cache::put($cacheKey,$response,now()->addMinutes(5));
            return $response;
        }
    }

    public function store(Request $request, Company $company)
    {
        // Validate the image
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:16384|dimensions:min_width=100,min_height=100',
        ]);

        //set the image.
        $company->setImage($request->image);

        // // Flash success messsage and redirect
        session()->flash('success', 'Logo uploaded!, please allow upto 5 minutes to see the changes!');
        return redirect("/companies/$company->id");
    }
}
