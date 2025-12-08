<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Enums\ModuleCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{

    public function index()
    {
        $modules = Module::orderBy('category')->orderBy('name')->get();
        return view('modules.index', ['modules' => $modules]);
    }

    public function create()
    {
        return view('modules.create', [
            'categories' => ModuleCategory::cases()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateModule($request);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('modules', 'public');
            $imagePath = basename($path);
        }

        Module::create([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'price' => $validated['price'],
            'required_time' => $validated['required_time'],
            'image_path' => $imagePath,
            // We save the 'specs' array as the JSON column
            'specifications' => $this->cleanSpecifications($request->input('specs'), $validated['category']),
        ]);

        return redirect()->route('modules.index')->with('success', 'Module succesvol aangemaakt.');
    }

    public function edit(Module $module)
    {
        return view('modules.edit', [
            'module' => $module,
            'categories' => ModuleCategory::cases()
        ]);
    }

    public function update(Request $request, Module $module)
    {
        $validated = $this->validateModule($request, $module->id);

        $data = [
            'name' => $validated['name'],
            'category' => $validated['category'],
            'price' => $validated['price'],
            'required_time' => $validated['required_time'],
            'specifications' => $this->cleanSpecifications($request->input('specs'), $validated['category']),
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('modules', 'public');
            $data['image_path'] = basename($path);
        }

        $module->update($data);

        return redirect()->route('modules.index')->with('success', 'Module bijgewerkt.');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return back()->with('success', 'Module verwijderd (Soft Delete).');
    }

    private function validateModule(Request $request, $id = null)
    {
        return $request->validate([
            'name' => 'required|string|max:255|unique:modules,name,' . $id,
            'category' => ['required', new Enum(ModuleCategory::class)],
            'price' => 'required|integer|min:0',
            'required_time' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048', // Max 2MB
            'specs' => 'nullable|array', // The array of extra fields
        ]);
    }

    private function cleanSpecifications(?array $input, string $category): array
    {
        if (!$input) return [];

        // Define allowed keys per category
        $allowed = match($category) {
            'chassis' => ['wheel_count', 'vehicle_type', 'dimensions'],
            'aandrijving' => ['fuel_type', 'horsepower'],
            'wielen' => ['tire_type', 'diameter', 'compatible_chassis'],
            'stuur' => ['shape', 'modifications'],
            'stoelen' => ['material'], // example
            default => []
        };

        return array_intersect_key($input, array_flip($allowed));
    }
}
