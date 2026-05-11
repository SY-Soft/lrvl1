<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\NewsImageService;
class DevelController extends Controller
{


    public function develForm()
    {
        return view('devel.form');
    }

    public function develGo(
        Request $request,
        NewsImageService $imageService
    )
    {
        $count = (int)$request->count;
        if ($request->action == 'gen_users' && $count>0) {
            $_r=0;
            for ($i = 1; $i <= $count; $i++) {

                User::create([
                    'name' => 'User ' . $i,
                    'email' => 'user' . $i . '@test.local',
                    'password' => Hash::make('123456'),
                    'role' => $_r
                ]);
                $_r++; if($_r>3) $_r=0;
            }

            return back()->with('msg', $count.' users created');
        }
        if ($request->action == 'truncate_users') {

            User::where('id','>',1)->delete();

            return back()->with('msg',"Users deleted");
        }
        if ($request->action == 'gen_news' && $count>0)
        {


            $users = User::whereIn('role', [1,2,3])->get();

            if ($users->isEmpty()) {
                return back()->with('error', 'Нет пользователей');
            }

            for ($i = 1; $i <= $count; $i++) {

                $user = $users->random();

                $imagePath = null;

                $randomImage = public_path('test-images/test' . rand(1,88) . '.jpg');

                if (file_exists($randomImage)) {
                    $imagePath = $imageService->saveFromPath($randomImage);
                }

                News::create([
                    'title' => 'Тестовая новость ' . $i,
                    'slug' => Str::slug('Тестовая новость ' . $i . '-' . time() . '-' . $i),
                    'body' => '<p>Тестовый текст новости #' . $i . '</p>',
                    'image' => $imagePath,
                    'published' => 1,
                    'user_id' => $user->id,
                ]);
            }

            return back()->with('success', 'Новости созданы');
        }
        if ($request->action == 'truncate_news') {

            $newsList = News::all();

            foreach ($newsList as $news) {

                if ($news->image) {
                    Storage::disk('public')->delete($news->image);
                }

                $news->delete();
            }

            return back()->with('msg', 'News deleted');
        }
        return back();
    }


    public function loginAs(User $user)
    {
        Auth::login($user);
        return redirect('/');
    }


}
