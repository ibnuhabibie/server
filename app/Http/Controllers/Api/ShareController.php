<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShareRequest;
use App\Repositories\ShareRepository;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ShareController extends Controller
{
    /** @var ShareRepository */
    protected $repository;

    /**
     * ShareController constructor.
     *
     * @param ShareRepository $repository
     */
    public function __construct(ShareRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the incoming request.
     *
     * @param ShareRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(ShareRequest $request)
    {
        $share = $this->repository->create([
            'data' => $request->get('error'),
            'selection' => $request->get('lineSelection'),
            'ip' => $request->ip(),
            'token' => Str::random(24)
        ]);

        Redis::set($request->getKey(), 1, 'EX', 60); // 1 min

        return response()->json([
            'public_url' => route('share.show', $share->id) . ($share->selection ?: ''),
            'owner_url' => route('share.show', [
                'share' => $share->id,
                'token' => $share->token
            ]) . ($share->selection ?: ''),
        ], Response::HTTP_OK);
    }
}
