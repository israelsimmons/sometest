<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use App\Models\SharePurchase;

class SharePurchasesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        Log::info($user);

        $res = SharePurchase::with('tags')->where(['user_id' => $user->id]);

        $direction = 'ASC';
        Log::info($request->all());
        if (intval($request->input('order')) < 0) {
            $direction = 'DESC';
        }

        $res->orderBy('company_name', $direction);
        $shares = $res->paginate(5);

        if ($request->ajax()){
            return response()->json(compact('shares'));
        }
        return view('shares.index', compact('shares'));

    }

    public function apiIndex()
    {
        $user = Auth::user();

        Log::info($user);

        $res = SharePurchase::with('tags')->where(['user_id' => $user->id]);

        $direction = 'ASC';
        Log::info($request->all());
        if (intval($request->input('order')) < 0) {
            $direction = 'DESC';
        }

        $res->orderBy('company_name', $direction);
        $shares = $res->paginate(5);

        return response()->json(compact('shares'));
    }

    public function show($id)
    {
        $share = SharePurchase::where([
            'user_id' => Auth::user()->id,
            'id' => $id
        ])->first();

        if ($share) {
            return view('shares.show')->with(compact('share'));
        }
    }

    public function create()
    {
        return view('shares.form');
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'company_name', 'instrument_name', 'quantity',
            'price', 'total_investment', 'certificate_number', 'transaction_date'
        ]);

        $data['user_id'] = Auth::user()->id;

        if ($request->input('id') != ''){
            $shareStored = SharePurchase::find($request->input('id'));

            foreach ($data as $key => $value) {
                $shareStored->{$key} = $value;
            }

            $shareStored->save();
        } else {

            $shareStored = SharePurchase::create($data);
        }

        if ($shareStored) {
            return redirect()->route('shares.index');
        } else {
            return redirect('shares.create')->with($request);
        }

    }

    public function delete()
    {

    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');

        SharePurchase::where('id', $id)->delete();

        return back()->with('message', 'Share deleted!');
    }

}
