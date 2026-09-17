<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LibroController extends Controller
{
    public function index()
    {
        $libros = Libro::all();
        return view('backend.libros.index', compact('libros'));
    }

    public function create()
    {
        return view('backend.libros.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo'  => 'required|string|max:255',
            'autor'   => 'required|string|max:255',
            'genero'  => 'required|string|max:255',
            'anio'    => 'required|integer|min:1500|max:' . date('Y'),
            'estado'  => 'required|in:disponible,prestado',
            'portada' => 'nullable|image|max:2048', // Nueva validación para portada
        ]);

        if ($request->hasFile('portada')) {
            $validated['portada'] = $request->file('portada')->store('portadas', 'public');
        }

        Libro::create($validated);

        return redirect()->route('libros.index')->with('success', 'Libro creado correctamente.');
    }

    public function show(Libro $libro)
    {
        return view('backend.libros.show', compact('libro'));
    }

    public function edit(Libro $libro)
    {
        return view('backend.libros.edit', compact('libro'));
    }

    public function update(Request $request, Libro $libro)
    {
        $validated = $request->validate([
            'titulo'  => 'required|string|max:255',
            'autor'   => 'required|string|max:255',
            'genero'  => 'required|string|max:255',
            'anio'    => 'required|integer|min:1500|max:' . date('Y'),
            'estado'  => 'required|in:disponible,prestado',
            'portada' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('portada')) {
            // Eliminar la portada anterior si existe
            if ($libro->portada && Storage::disk('public')->exists($libro->portada)) {
                Storage::disk('public')->delete($libro->portada);
            }

            $validated['portada'] = $request->file('portada')->store('portadas', 'public');
        }

        $libro->update($validated);

        return redirect()->route('libros.index')->with('success', 'Libro actualizado correctamente.');
    }

    public function destroy(Libro $libro)
    {
        if ($libro->portada && Storage::disk('public')->exists($libro->portada)) {
            Storage::disk('public')->delete($libro->portada);
        }

        $libro->delete();

        return redirect()->route('libros.index')->with('success', 'Libro eliminado correctamente.');
    }
}
