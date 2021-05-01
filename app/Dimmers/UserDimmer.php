<?php
namespace App\Dimmers;
use App\Models\User;
use Illuminate\Support\Str;
use TCG\Voyager\Widgets\BaseDimmer;

class UserDimmer extends  BaseDimmer
{
    /***
     * * The configuration array.*
     * **
     * * @var array*
     * */
    protected $config = [];
    /***
     * * Treat this method as a controller action.*
     * * Return view() or other content to display.*
     * */
    public function run()
    {
        $count = User::where('role_id','2')->count();
        $string = trans_choice('Users', $count);
        return view('voyager::dimmer', array_merge($this->config, [
            'icon' => 'voyager-person',
            'title' => "{$count} {$string}",
            'text'=> __('Users',['count'=>$count,'string'=>Str::lower($string)]),
            'button' => [
                'text' => 'Users',
                'link' => route('voyager.users.index'),
            ],
            'image' => voyager_asset('images/widget-backgrounds/01.jpg'),
        ]));
    }
}
