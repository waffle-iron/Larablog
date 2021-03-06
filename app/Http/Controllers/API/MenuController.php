<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Menu;
use Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $menus = [];
        $menus['right'] = Menu::whereEmplacement('right')->orderBy('weight')->get();
        $menus['left'] = Menu::whereEmplacement('left')->orderBy('weight')->get();

        return $menus;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $menu = new Menu();

        switch (Request::input('type')) {
            case 'page':
                $menu->url = route('page.show', Request::input('url'));
                break;

            case 'homepage':
                $menu->url = route('home');
                break;

            case 'portfolio':
                $menu->url = route('portfolio');
                break;

            case 'category':
                $menu->url = '';
                $menu->is_category_dropdown = true;
                break;

            case 'blogindex':
                $menu->url = route('post.index');
                break;

            case 'login':
                $menu->url = url('login');
                $menu->is_login_link = true;
                break;

            case 'register':
                $menu->url = url('register');
                break;

            case 'searchform':
                $menu->url = '';
                $menu->is_search_form = true;
                break;

            default:
                $menu->url = Request::input('url');
                break;
        }

        $menu->name = Request::input('name');
        $menu->emplacement = 'left';
        $menu->save();

        return $menu;
    }

    public function updateOrder()
    {
        $leftmenus = Request::input('left');

        foreach ($leftmenus as $key => $item) {
            $menu = Menu::find($item['id']);
            $menu->weight = $key;
            $menu->emplacement = 'left';
            $menu->save();
        }

        $rightmenus = Request::input('right');

        foreach ($rightmenus as $key => $item) {
            $menu = Menu::find($item['id']);
            $menu->weight = $key;
            $menu->emplacement = 'right';
            $menu->save();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id = null)
    {
        $menu = Menu::find(Request::input('id'));
        $menu->delete();
    }
}
