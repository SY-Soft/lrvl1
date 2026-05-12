<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\NewsImageService;
class NewsController extends Controller
{

    public function __construct()
    {
        // Применяем Policy только к admin-действиям
        $this->middleware('auth')->only([
            'create', 'store', 'edit', 'update', 'destroy', 'admin_index'
        ]);

        $this->authorizeResource(News::class, 'news', [
            'except' => ['index', 'show']   // исключаем публичные страницы
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $this->authorize('viewAny', News::class); // если хочешь ограничить

        $news = News::where('published', true)
            ->orderBy('id','desc')
            ->paginate(10);

        return view('news.index', compact('news'));

        // $news = News::orderBy('id','desc')->paginate(10);
        // return view('news.index',compact('news'));
    }
    public function admin_index()
    {
        $news = News::orderBy('id','desc')->paginate(10);

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

        // Правильный вызов авторизации
        $this->authorize('view', $news);   // ← важно передавать именно $news, а не News::class

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
    /**
     * Переключение публикации новости (AJAX)
     */
    public function togglePublish(Request $request, News $news)
    {
        $this->authorize('public', $news);   // проверяем право через Policy

        $news->published = !$news->published;
        $news->save();

        return response()->json([
            'success' => true,
            'published' => $news->published,
            'id' => $news->id
        ]);
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
