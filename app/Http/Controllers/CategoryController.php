<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Category;

class CategoryController extends Controller
{

	private function adminCheck() {

		if(Auth::check() && Auth::user()->user_type !== 2) {
			abort(404);
		}
	}

    public function __construct(){

    	$this->middleware('auth');
    }

    public function addCategory() {

    	$this->adminCheck();

        return view('profile.addcategory');
    }

    public function saveCategory(Request $request) {

    	$this->adminCheck();

        $validation = array(
            'name' => 'required|max:120'
        );

        $vl = Validator::make($request->all(), $validation);

        if ($vl->fails()) {
            return back()
                ->withInput()
                ->withErrors($vl);
        } else {

            $category = new Category;
            $category->name = strtolower($request->name);
            $category->save();
        }

        return back()->with('message', 'Category added successfully..');
    }

    public function editCategory($id) {

    	$this->adminCheck();

    	$category = Category::findOrFail($id);

        return view('profile.editcategory' , compact('category'));
    }

    public function updateCategory(Request $request) {

        $this->adminCheck();

        $validation = array(
            'name' => 'required|max:120'
        );

        $vl = Validator::make($request->all(), $validation);

        if ($vl->fails()) {
            return back()
                ->withInput()
                ->withErrors($vl);
        } else {

            $category = array(
                    'name' => strtolower($request->name)
            );
        }

        return back()->with('message', 'Category updated successfully..');
    }

    public function showCategory() {

    	$this->adminCheck();

		$categories = Category::paginate(20);

    	return view('profile.showcategories' , compact('categories'));
    }
}
