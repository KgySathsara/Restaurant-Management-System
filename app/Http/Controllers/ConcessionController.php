<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConcessionRequest;
use App\Http\Requests\UpdateConcessionRequest;
use App\Repositories\Interfaces\ConcessionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ConcessionController extends Controller
{
    private $concessionRepository;

    public function __construct(ConcessionRepositoryInterface $concessionRepository)
    {
        $this->concessionRepository = $concessionRepository;
        Log::info('ConcessionController initialized');
    }

    public function index()
    {
        Log::info('Accessing concessions index page');
        $concessions = $this->concessionRepository->all();
        Log::debug('Retrieved concessions', ['count' => $concessions->count()]);
        return view('concessions.index', compact('concessions'));
    }

    public function create()
    {
        Log::info('Accessing concession creation form');
        return view('concessions.create');
    }

    public function store(StoreConcessionRequest $request)
    {
        Log::info('Starting concession creation process');
        $data = $request->validated();
        Log::debug('Validated concession data', ['data' => $data]);

        if ($request->hasFile('image')) {
            Log::debug('Image file received', [
                'original_name' => $request->file('image')->getClientOriginalName(),
                'size' => $request->file('image')->getSize()
            ]);
            $data['image'] = $request->file('image')->store('concessions', 'public');
            Log::info('Image stored successfully', ['path' => $data['image']]);
        }

        $concession = $this->concessionRepository->create($data);
        Log::info('Concession created successfully', ['concession_id' => $concession->id]);

        return redirect()->route('concessions.index')
            ->with('success', 'Concession created successfully.');
    }

    public function show($id)
    {
        Log::info('Viewing concession details', ['concession_id' => $id]);
        $concession = $this->concessionRepository->find($id);
        Log::debug('Retrieved concession details', ['concession' => $concession]);
        return view('concessions.show', compact('concession'));
    }

    public function edit($id)
    {
        Log::info('Editing concession', ['concession_id' => $id]);
        $concession = $this->concessionRepository->find($id);
        Log::debug('Retrieved concession for editing', ['concession' => $concession]);
        return view('concessions.edit', compact('concession'));
    }

    public function update(UpdateConcessionRequest $request, $id)
    {
        Log::info('Updating concession', ['concession_id' => $id]);
        $data = $request->validated();
        Log::debug('Validated update data', ['data' => $data]);

        $concession = $this->concessionRepository->find($id);
        Log::debug('Current concession data', ['current_data' => $concession]);

        if ($request->hasFile('image')) {
            Log::debug('New image file received for update', [
                'original_name' => $request->file('image')->getClientOriginalName(),
                'size' => $request->file('image')->getSize()
            ]);

            // Delete old image
            if ($concession->image) {
                Storage::disk('public')->delete($concession->image);
                Log::info('Old image deleted', ['path' => $concession->image]);
            }

            $data['image'] = $request->file('image')->store('concessions', 'public');
            Log::info('New image stored', ['path' => $data['image']]);
        }

        $this->concessionRepository->update($id, $data);
        Log::info('Concession updated successfully', ['concession_id' => $id]);

        return redirect()->route('concessions.index')
            ->with('success', 'Concession updated successfully.');
    }

    public function destroy($id)
    {
        Log::info('Deleting concession', ['concession_id' => $id]);
        $concession = $this->concessionRepository->find($id);
        Log::debug('Concession to be deleted', ['concession' => $concession]);

        if ($concession->image) {
            Storage::disk('public')->delete($concession->image);
            Log::info('Concession image deleted', ['path' => $concession->image]);
        }

        $this->concessionRepository->delete($id);
        Log::info('Concession deleted successfully', ['concession_id' => $id]);

        return redirect()->route('concessions.index')
            ->with('success', 'Concession deleted successfully.');
    }
}
