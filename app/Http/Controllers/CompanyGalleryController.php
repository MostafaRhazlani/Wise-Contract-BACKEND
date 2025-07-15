<?php

namespace App\Http\Controllers;

use App\Models\CompanyGallery;
use Illuminate\Http\Request;

class CompanyGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($company_id)
    {
        try {
            $companyGallery = CompanyGallery::where('company_id', $company_id)->get();

            return response()->json(['company_gallery' => $companyGallery], 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'company_id' => 'required|exists:companies,id',
        ]);

        try {
            // Store the image
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $uniqueImageName = time() . '_' . uniqid() . '.' . $extension;

            // Store the image with the unique name in the 'public/company_gallery' directory
            $imagePath = $image->storeAs('company_gallery', $uniqueImageName, 'public');

            $gallery = CompanyGallery::create([
                'image_name' => uniqid(),
                'image' => $imagePath,
                'company_id' => $validated['company_id'],
            ]);

            return response()->json([
                'gallery' => $gallery,
                'success' => 'image uploaded successfully'
            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyGallery $companyGallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyGallery $companyGallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CompanyGallery $companyGallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyGallery $companyGallery)
    {
        //
    }
}
