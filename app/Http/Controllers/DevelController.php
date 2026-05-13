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
            $_users_count=count($users);
            $_users_i=0;

            if ($users->isEmpty()) {
                return back()->with('error', 'Нет пользователей');
            }

            for ($i = 1; $i <= $count; $i++) {

                $user = $users[$_users_i];
                $_users_i++;
                if($_users_i==$_users_count) $_users_i=0;

                $imagePath = null;

                $randomImage = public_path('test-images/test' . rand(1,88) . '.jpg');

                if (file_exists($randomImage)) {
                    $imagePath = $imageService->saveFromPath($randomImage);
                }

                News::create([
                    'title' => 'Тестовая новость ' . $i,
                    'slug' => Str::slug('Тестовая новость ' . $i . '-' . time() . '-' . $i),
                    'body' => '<p><strong>Тестовый текст новости #' . $i . '</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam consectetur mi lectus, sit amet lobortis lacus porttitor sit amet. Nullam a libero feugiat, interdum sem non, ornare metus. Suspendisse potenti. Donec at scelerisque diam, non posuere urna. Aenean congue est nec augue aliquam, sit amet molestie libero facilisis. Curabitur molestie libero a nisl vulputate, sit amet iaculis nisl luctus. Ut in dolor bibendum, malesuada neque ac, rutrum dolor. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent condimentum eros sit amet consequat vulputate. Nunc metus leo, viverra eu cursus nec, imperdiet id odio. Sed hendrerit venenatis ex. Suspendisse vel volutpat lectus. Cras faucibus tortor metus, eu pulvinar urna vulputate nec. Sed in quam vitae ex malesuada aliquet. Vestibulum commodo neque nec laoreet sollicitudin. Nam nec posuere turpis, eget pretium leo.</p>
<p>Aliquam non leo id dolor eleifend vestibulum. Integer ex mauris, ullamcorper in accumsan id, placerat ac nunc. Nullam et malesuada sem. Sed a ante lacinia, rutrum mauris et, condimentum lorem. Nullam volutpat in elit nec fermentum. Nulla ut volutpat diam. Quisque interdum quam eget lorem fermentum, vitae commodo orci consequat. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla sit amet sem facilisis, feugiat nisi in, facilisis nulla. Maecenas aliquam vel eros pharetra convallis. Maecenas convallis et mauris vel vehicula. Proin leo quam, ullamcorper vitae ultrices ut, dictum nec lectus. Sed ut tempor sapien.</p>
<p>Nunc auctor turpis at finibus posuere. Donec suscipit vulputate diam, a auctor orci. Sed et facilisis quam, et tristique elit. Phasellus enim ligula, congue quis lacus nec, faucibus faucibus eros. Morbi suscipit aliquam metus, et cursus ante fermentum ultricies. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc urna libero, accumsan eu augue non, blandit condimentum augue. Phasellus quis consequat sapien. Nunc sit amet pretium enim, sit amet tincidunt mauris. Cras consequat, orci molestie euismod aliquet, magna mi pretium est, ultrices sollicitudin arcu magna placerat sapien. Fusce in vestibulum nulla, at varius turpis. Integer vestibulum malesuada tellus, vitae volutpat ligula consequat ut. Morbi aliquet non eros dignissim vulputate. Morbi venenatis nisl vitae tellus eleifend, et aliquet tortor faucibus. Etiam dictum fermentum purus, sed dapibus diam egestas non.</p>
<p>Suspendisse fermentum quam at eros tempus volutpat. Morbi ornare purus quis elit ultrices, tincidunt efficitur arcu commodo. Sed vitae dolor a eros iaculis tincidunt. Duis volutpat varius justo vitae finibus. Phasellus eu mi in nisl malesuada ultrices. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Phasellus vel luctus lacus. Vestibulum sollicitudin sodales metus, et interdum quam ornare in. Phasellus fermentum mi nibh, non elementum enim imperdiet non. Nunc consectetur fringilla vehicula. Integer sagittis ultricies felis, sed vestibulum magna consectetur nec. Morbi tristique vehicula sem, in vehicula lorem convallis sit amet.</p>
<p>Etiam non fringilla justo. Nunc ac venenatis urna. Pellentesque maximus condimentum diam eu condimentum. Aliquam odio nunc, fermentum vitae consectetur vitae, ultricies a mi. Etiam commodo laoreet scelerisque. Quisque sed lacus id felis ultrices facilisis a sed neque. Nullam ac fringilla felis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed eget ligula egestas ipsum lobortis hendrerit vitae dapibus elit. Proin nunc ligula, vestibulum vel rhoncus non, fermentum ut metus. Vivamus sit amet tellus sit amet diam faucibus semper. Sed non malesuada nisi.</p>',
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
