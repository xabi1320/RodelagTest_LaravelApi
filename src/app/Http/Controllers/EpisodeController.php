<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Implementation\EpisodeServiceImpl;
use App\Validator\EpisodeValidator;

class EpisodeController extends Controller
{
    /**
     * @var EpisodeServiceImpl
    */
    private $espisodeService;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var EpisodeValidator
     */
    private $validator;

    public function __construct(
        EpisodeServiceImpl $espisodeService,
        Request $request,
        EpisodeValidator $episodeValidator
    )
    {
        $this->espisodeService = $espisodeService;
        $this->request = $request;
        $this->validator = $episodeValidator;
    }

    function createEpisode()
    {
        $response = response("", 201);
        $validator = $this->validator->validate();

        if ($validator->fails()) {
            $response = response([
                "status" => 422,
                "message" => "Error",
                "errors" => $validator->errors(),
            ], 422);
        } else {
            $this->espisodeService->postEpisode($this->request->all());
        }

        return $response;
    }

    function getListEpisodes()
    {
        return response($this->espisodeService->getEpisodes());
    }

    // function getEpisodeByCode(string $code)
    // {
    //     return response($this->espisodeService->getEpisodeByCode($code));
    // }

    function patchEpisode(int $id)
    {
        $response = response("", 202);

        $this->espisodeService->patchEpisode($this->request->all(), $id);

        return $response;
    }

    function deleteEpisode(int $id)
    {
        $this->espisodeService->delEpisode($id);

        return response("", 204);
    }

    function restoreEpisode(int $id)
    {
        $this->espisodeService->restoreEpisode($id);

        return response("", 204);
    }
}
