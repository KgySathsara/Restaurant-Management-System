<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConcessionRequest;
use App\Http\Requests\UpdateConcessionRequest;
use App\Repositories\Interfaces\ConcessionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConcessionController extends Controller
{
    private $concessionRepository;

    public function __construct(ConcessionRepositoryInterface $concessionRepository)
    {
        $this->concessionRepository = $concessionRepository;
    }

    public function index()
    {
        $concessions = $this->concessionRepository->all();
        return view('concessions.index', compact('concessions'));
    }

    public function create()
    {
        return view('concessions.create');
    }

    public function store(StoreConcessionRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('concessions', 'public');
        }

        $this->concessionRepository->create($data);

        return redirect()->route('concessions.index')->with('success', 'Concession created successfully.');
    }

    public function show($id)
    {
        $concession = $this->concessionRepository->find($id);
        return view('concessions.show', compact('concession'));
    }

    public function edit($id)
    {
        $concession = $this->concessionRepository->find($id);
        return view('concessions.edit', compact('concession'));
    }

    public function update(UpdateConcessionRequest $request, $id)
    {
        $data = $request->validated();
        $concession = $this->concessionRepository->find($id);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($concession->image);
            $data['image'] = $request->file('image')->store('concessions', 'public');
        }

        $this->concessionRepository->update($id, $data);

        return redirect()->route('concessions.index')->with('success', 'Concession updated successfully.');
    }

    public function destroy($id)
    {
        $concession = $this->concessionRepository->find($id);

        // Delete image
        Storage::disk('public')->delete($concession->image);

        $this->concessionRepository->delete($id);

        return redirect()->route('concessions.index')->with('success', 'Concession deleted successfully.');
    }
}
