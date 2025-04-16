<?php

namespace App\Http\Controllers\Publisher;

use App\Models\Book;
use App\Models\AudioVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use getID3;

class AudioVersionController extends BaseController
{

    public function index()
    {
        // Get all audio versions that belong to the current publisher
        $audioVersions = AudioVersion::where('created_by', auth()->id())
            ->with(['book', 'creator'])
            // ->where('is_published', 'accepted')
            ->latest()
            ->get();
            
        return $this->view('audio-versions.index', compact('audioVersions'));
    }

    public function create(Request $request)
    {
         // Check if publisher can create more books
         $user = auth()->user();
        //  $canCreateBook = $user->publishedBooks()->count() < 5 || $user->hasActiveSubscription;
         $canCreateAudio = $user->audioVersionsCreated()->count() < 5 || $user->hasActiveSubscription;
         if (!$canCreateAudio) {
            return redirect()->route('publisher.books.index')
                ->with('error', 'You have reached your book limit. Please subscribe to publish more.');
        }
        $book = null;
        $books = Book::where('is_published', 'accepted')->get();
        
        if ($request->has('book_id')) {
            $book = Book::findOrFail($request->book_id);
        }
        
        $type = 'create';
        return $this->view('audio-versions.create', compact('books', 'book', 'type',
        'canCreateAudio'));
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'audio_full' => 'required|file|mimes:mp3,wav,aac|max:65536',
            'audio_duration' => 'numeric|min:0',

            'language' => 'required|string|max:10',
            'audio_review' => 'nullable|file|mimes:mp3,wav,aac|max:2048', 
            'audio_duration' => 'required|string|regex:/^\d{2,3}:[0-5][0-9]:[0-5][0-9]$/', // HH:MM:SS format

        ]);

        $book = Book::findOrFail($validated['book_id']);
        
        // Convert HH:MM:SS to seconds
        $durationInSeconds = $this->timeToSeconds($validated['audio_duration']);

        // Store files
        $audioPath = $request->file('audio_full')->store('books/audio_versions', 'public');
        $reviewPath = null;
        
        if ($request->hasFile('audio_review')) {
            $reviewPath = $request->file('audio_review')->store('books/review_audios', 'public');
        }

        AudioVersion::create([
            'book_id' => $validated['book_id'],
            'audio_link' => $audioPath,
            'review_record_link' => $reviewPath,
            'language' => $validated['language'],
            'audio_duration' => $durationInSeconds,
            'created_by' => auth()->id(),
            'is_published' => 'waiting',
        ]);

        return redirect()->route('publisher.books.index', ['#audio'])
        ->with('success', 'Audio version added successfully!');
    }


    public function show($id)
    {        
        $audioVersion = AudioVersion::with('book')
            ->where('created_by', auth()->id())
            ->findOrFail($id);
            $books = Book::where('is_published', 'accepted')->get();

        return $this->view('audio-versions.show', compact('audioVersion', 'books'));
    }

    public function edit($id)
    {          $canCreateAudio =true;
        $audioVersion = AudioVersion::where('created_by', auth()->id())
            ->with('book')
            ->findOrFail($id);
            
            $books = Book::where('is_published', 'accepted')->get();
        $type = 'edit';
        return $this->view('audio-versions.create', compact('audioVersion', 'books', 'type','canCreateAudio'));
    }

    public function update(Request $request, $id)
    {
        $audioVersion = AudioVersion::where('created_by', auth()->id())
            ->findOrFail($id);

        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'audio_full' => 'nullable|file|mimes:mp3,wav,aac|max:65536',
            'language' => 'required|string|max:10',
            'audio_review' => 'nullable|file|mimes:mp3,wav,aac|max:65536',
            'audio_duration' => 'required|string|regex:/^\d{2,3}:[0-5][0-9]:[0-5][0-9]$/', // HH:MM:SS format

        ]);

        $book = Book::where('published_by', auth()->id())
                   ->findOrFail($validated['book_id']);

        // Convert HH:MM:SS to seconds
        $durationInSeconds = $this->timeToSeconds($validated['audio_duration']);

        $data = [
            'book_id' => $validated['book_id'],
            'language' => $validated['language'],
            'audio_duration' => $durationInSeconds,
        ];

        // Update audio file if provided
        if ($request->hasFile('audio_full')) {
            // Delete old file
            if ($audioVersion->audio_link) {
                Storage::disk('public')->delete($audioVersion->audio_link);
            }
            
            $data['audio_link'] = $request->file('audio_full')->store('books/audio_versions', 'public');
        }

        // Update review file if provided
        if ($request->hasFile('audio_review')) {
            // Delete old file
            if ($audioVersion->review_record_link) {
                Storage::disk('public')->delete($audioVersion->review_record_link);
            }
            
            $data['review_record_link'] = $request->file('audio_review')->store('books/audio_reviews', 'public');
        }

        $audioVersion->update($data);

        return redirect()->route('publisher.books.index', ['#audio'])
        ->with('success', 'Audio version added updated!');
    }

    public function destroy($id)
    {
        $audioVersion = AudioVersion::where('created_by', auth()->id())
            ->findOrFail($id);

        if ($audioVersion->audio_link) {
            Storage::disk('public')->delete($audioVersion->audio_link);
        }
        
        if ($audioVersion->review_record_link) {
            Storage::disk('public')->delete($audioVersion->review_record_link);
        }
        
        $audioVersion->delete();

        return redirect()->route('publisher.books.index', ['#audio'])
            ->with('success', 'Audio version deleted successfully!');
    }
    /**
     * Convert HH:MM:SS time format to seconds
     */
    protected function timeToSeconds($time)
    {
        $parts = explode(':', $time);
        $hours = (int)$parts[0];
        $minutes = (int)$parts[1];
        $seconds = (int)$parts[2];
        
        return ($hours * 3600) + ($minutes * 60) + $seconds;
    }

    /**
     * Get audio duration in seconds using getID3 library
     */
    protected function getAudioDuration($file)
    {
        $getID3 = new getID3();
        $fileInfo = $getID3->analyze($file->getPathname());
        
        return $fileInfo['playtime_seconds'] ?? 0;
    }
}