<?php

namespace App\Http\Controllers;

use App\DynamoDbShare;
use App\Http\Requests\DeleteShareRequest;
use App\Share;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    /**
     * Show the Share.
     *
     * @param DynamoDbShare|Share $share
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function show($share, Request $request)
    {
        return view()->make('share', compact('share'));
    }

    /**
     * Delete an existing Share.
     *
     * @param DynamoDbShare|Share $share
     * @param DeleteShareRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete($share, DeleteShareRequest $request)
    {
        $share->delete();

        return redirect()->to('/');
    }
}
