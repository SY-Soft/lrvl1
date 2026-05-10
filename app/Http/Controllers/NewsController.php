<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\NewsImageService;
class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::orderBy('id','desc')->paginate(10);
        return view('news.index',compact('news'));
    }
    public function admin_index()
    {
        $news = News::orderBy('id','asc')->paginate(10);

        return view('news.admin_index',compact('news'));

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        Request $request,
        NewsImageService $imageService
    )
    {
        $data = $request->validate([
            'title' => 'required|string|max:255|min:3',
            'body' => 'required',
            'image' => 'nullable|image',
        ]);

        /*
        if ($request->hasFile('image')) {
            $data['image'] = $this->saveNewsImage(
                $request->file('image')
            );
        }
        */
        if ($request->hasFile('image')) {
            $data['image'] = $imageService->saveUploaded(
                $request->file('image')
            );
        }

        $data['user_id'] = auth()->id();
        $data['published'] = $request->has('published');
        // dd($data);        $data['user_id'] = 1;
        News::create($data);

        return redirect()->route('news.admin_index');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();

        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $this->authorize('update', $news);
        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(        Request $request,
                                   NewsImageService $imageService, string $id)
    {
        $news = News::findOrFail($id);

        $this->authorize('update', $news);

        $data = $request->validate([
            'title' => 'required|string|max:255|min:3',
            'body' => 'required',
            'image' => 'nullable|image',
        ]);

        // если загрузили новую картинку
        if ($request->hasFile('image')) {

            // удалить старую (если есть)
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }

            $data['image'] = $imageService->saveUploaded(
                $request->file('image')
            );
        }

        $data['published'] = $request->has('published');

        $news->update($data);

        return redirect()->route('news.admin_index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $this->authorize('delete', $news);

        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()
            ->route('news.admin_index')
            ->with('success', 'Новость удалена');
    }

    /*
    private function saveNewsImage($file)
    {
        $originalName = pathinfo(
            $file->getClientOriginalName(),
            PATHINFO_FILENAME
        );

        $extension = $file->getClientOriginalExtension();

        // транслит + slug
        $baseName = Str::slug($originalName);

        if (!$baseName) {
            $baseName = 'image';
        }

        $fileName = $baseName . '.' . $extension;
        $counter = 0;

        while (Storage::disk('public')->exists('images/news/' . $fileName)) {
            $fileName = $baseName . '_' . $counter . '.' . $extension;
            $counter++;
        }

        return $file->storeAs(
            'images/news',
            $fileName,
            'public'
        );
    }
    */
}
