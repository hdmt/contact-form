<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Input extends Component
{
    public $posts;
    public $requestList;
    public $prefectures;
    
    protected $rules = [
        'posts.name' => 'required',
        'posts.mail' => 'required|email',
        'posts.request' => 'required|array',
        'posts.tel' => 'required',

    ];

    protected $messages = [
        'posts.*.required' => '必須項目です',
        'posts.mail.email' => '正しいメールアドレスを入力ください',
    ];

    public function mount()
    {
        $this->requestList = config('contact.requests');
        $this->prefectures = config('contact.prefectures');
        $this->posts = session()->get('posts');

    }

    public function confirm()
    {
        $this->validate();

        //セッション登録
        session()->put('posts', $this->posts);

        return redirect()->route('confirm');
    }

    public function updatedPosts()
    {
        if(!empty($this->posts['request'])) {
            $this->posts['request'] = array_filter(
                $this->posts['request'],
                function($value) {
                    return $value !== false;
                }
            );
        }
    }

    public function render()
    {
        return view('livewire.input');
    }


}
