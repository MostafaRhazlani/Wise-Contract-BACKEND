<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function companyTemplates($company_id) {

        try {
            $templates = Template::where('company_id', $company_id)->get();
            return response()->json(['templates' => $templates], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
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
            'content_json' => 'required',
            'company_id' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        try {
            // Generate unique name for the image
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $uniqueImageName = time() . '_' . uniqid() . '.' . $extension;

            // Store the image with the unique name in the 'public/images' directory
            $imagePath = $image->storeAs('template_images', $uniqueImageName, 'public');

            $template = Template::create([
                'content_json' => $validated['content_json'],
                'company_id' => $validated['company_id'],
                'image' => $imagePath
            ]);

            return response()->json([
                'template' => $template,
                'success' => 'template created successfully'
            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $template = Template::findOrFail($id);
            return response()->json([
                'template' => $template
            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Template $template)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Template $template)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        //
    }
}
