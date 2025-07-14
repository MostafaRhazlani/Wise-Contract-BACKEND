<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\TemplatePage;
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

    public function companyTemplatesWithType($company_id, $type_id) {

        try {
            $templates = Template::where('company_id', $company_id)->where('type_id', $type_id)->with('pages')->get();
            return response()->json(['templates' => $templates], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function companyTemplates($company_id) {

        try {
            $templates = Template::where('company_id', $company_id)->with('type', 'pages')->get();
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
            'content_json' => 'required|array',
            'content_json.*' => 'required',
            'company_id' => 'required|integer',
            'type_id' => 'required|integer',
            'image_path' => 'required|array',
            'image_path.*' => 'required|mimes:jpeg,png,jpg,gif,svg'
        ]);

        try {
            $template = Template::create([
                'company_id' => $validated['company_id'],
                'type_id' => $request->type_id,
            ]);

            $jsons = $validated['content_json'];
            $images = $request->file('image_path');

            foreach ($jsons as $i => $json) {

                // generate unique name for image
                $image = $images[$i] ?? null;
                if(!$image) continue;

                $extension = $image->getClientOriginalExtension();
                $uniqueImageName = time() . '_' . uniqid() . '.' . $extension;

                // Store the image with the unique name in the 'public/images' directory
                $imagePath = $image->storeAs('template_images', $uniqueImageName, 'public');

                $template_page = TemplatePage::create([
                    'image_path' => $imagePath,
                    'content_json' => $json,
                    'template_id' => $template->id,
                ]);
            }

            return response()->json([
                'template' => $template,
                'template_page' => $template_page,
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
            $template = Template::with('type')->findOrFail($id);
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
