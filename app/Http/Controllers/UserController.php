<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Initialize the query builder
        $query = User::query();

        // Handle search if provided
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('email', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $sortBy = $request->input('sortBy', 'created_at');  // Default to 'created_at'
        $sortOrder = $request->input('sortOrder', 'asc');  // Default to 'asc'

        
        if (in_array($sortBy, ['name', 'email', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'asc');
        }
        
        $page = 1;
        // Handle pagination if 'page' is provided
        if ($request->has('page')) {
            $page = $request->page;
            $users = $query->withCount('orders')->paginate(10);//display 10 rows per page
        } else {
            // If no pagination requested, return all results
            $users = $query->withCount('orders')->get();
        }

        $data = [
            'page' => $page,
            'users' =>  $users
        ];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ];
        $validator = Validator::make($data, [
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:users,email',  // Unique validation for email
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            // Handle the validation failure, e.g., return a response with errors
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $newuser = new User;
        $newuser->name = $request->name;
        $newuser->email = $request->email;
        $newuser->password = bcrypt($request->password);
        $newuser->save();
        $inserted = User::find($newuser->id);

        return response()->json($inserted, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
