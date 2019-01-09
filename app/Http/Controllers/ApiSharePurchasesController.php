<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Log;
use Validator;

use App\Models\SharePurchase;
use App\Models\Tag;

class ApiSharePurchasesController extends Controller
{

    /**
     * It returns a paginated JSON list of the shares registered by the user
     * @param  Request $request Laravel access to the request data
     */
    public function index(Request $request)
    {
        // get the user from the session (token in the API case)
        $user = Auth::user();

        // get an instance of the model we will work on
        $res = SharePurchase::with('tags')->where(['user_id' => $user->id]);

        // set the default direction for ordering the data
        $direction = 'ASC';

        if (intval($request->input('order')) < 0) {
            $direction = 'DESC';
        }

        // for now we can order by company_name, the logic here can be modified
        // to get from the query string the field to order by, it could be
        // something like ?order=company_name or ?order=-company_name for DESC order
        // or even better pass an index value to hide the field name from the user
        $res->orderBy('company_name', $direction);

        // We user the pagination method and store the instance of the model
        $shares = $res->paginate(5);

        // return a json response to be consumed by the fron-end
        return response()->json(compact('shares'));
    }

    /**
     * logic for the endpoint /shares/{shareId}
     * @param  integer $shareId The share id of the Share we are going to show
     */
    public function show($shareId)
    {
        // get the user from the session
        $user = Auth::user();

        // we need to make sure the Share belong the the user to avoid smart guys
        // trying to manipulate the query string
        $share = SharePurchase::with('tags')->where([
            'user_id' => $user->id,
            'id' => $shareId
        ])->first();

        // if a Share is found we return that JSON to the request,
        // if not found we return a JSON with an 404 http-code
        if ($share) {
            return response()->json(compact('share'));
        } else {
            return response()->json(['message' => 'Share not found'], 404);
        }
    }

    /**
     * Logic for the Share edit endpoint
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     */
    public function update(Request $request, $id)
    {
        $data = $request->input('share');

        $data['total_investment'] = $data['price'] * $data['quantity'];

        $share = SharePurchase::find($id);

        if ($share){
            if ($share->user_id != Auth::user()->id) {
                return response()->json(['message' => 'You can\'t modify a Share that doesn\'t belong to you!'], 403);
            }
        }

        foreach ($data as $key => $value) {
            $share->{$key} = $value;
        }

        try {
            $share->save();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(compact('share'));

    }

    public function store(Request $request)
    {
        $reqData = $request->only([
            'share.company_name', 'share.instrument_name', 'share.quantity',
            'share.price', 'share.total_investment', 'share.certificate_number',
            'share.transaction_date'
        ]);

        $data = $reqData['share'];
        $data['user_id'] = Auth::user()->id;

        $data['total_investment'] = $data['price'] * $data['quantity'];

        $validator = Validator::make($data, [
            'company_name'       => 'required|max:150',
            'instrument_name'    => 'required|max:150',
            'quantity'           => 'required|integer',
            'price'              => 'required|gt:0',
            'certificate_number' => 'required',
            'transaction_date'   => 'required|date'

        ])->validate();

        $share = SharePurchase::create($data);

        if ($share) {
            return response()->json(compact('share'));
        } else {
            return response()->json(['message' => 'Unknown error'], 500);
        }

    }

    public function destroy(Request $request, $id)
    {
        $user = Auth::user();

        $res = SharePurchase::where(['id' => $id, 'user_id' => $user->id])->delete();

        if ($res) {

            return response()->json(['message' => 'The Share was deleted successfuly']);
        } else {
            return response()->json(['message' => 'No content to delete'], 400);
        }
    }

    public function getTags()
    {
        $user = Auth::user();

        $tags = Tag::where('user_id', $user->id)->get();

        return response()->json(compact('tags'));

    }

    public function saveShareTags(Request $request, $shareId)
    {
        $data = $request->input('tags');

        $user = Auth::user();

        $share = SharePurchase::where(
            [
                'user_id' => $user->id,
                'id' => $shareId
            ]
        )->first();

        if ($share) {



        $share->tags()->sync($data);



        } else {
            return response()->json(['message' => 'Share not found'], 404);
        }
    }

}
