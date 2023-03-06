<?php
namespace App\Services\Implementation;

use App\Services\Interfaces\IEpisodeServiceInterface;
use App\Models\Episodes;
use GuzzleHttp\Client;

class EpisodeServiceImpl implements IEpisodeServiceInterface
{

    private $model;

    private $client;

    function __construct() {
        $this->model = new Episodes();
        $this->client = new Client([
            'base_uri' => 'https://rickandmortyapi.com/graphql',
        ]);
    }

    /**
     * Return all episodes
     */
    function getEpisodes() {
        $episodes = $this->model->withTrashed()->get();

        if (count($episodes) == 0) {
            $query = <<<'GRAPHQL'
                query {
                    episodes {
                        results {
                        name
                        episode
                        characters {
                            name
                            status
                            gender
                            image
                        }
                        }
                    }
                }
            GRAPHQL;

            $response = $this->client->post('', [
                'json' => [
                    'query' => $query,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            $episodes = $data['data']['episodes']['results'];

            foreach ($episodes as $episode) {
                $episode['characters'] = json_encode($episode['characters']);
                $this->postEpisode($episode);
            }

            return $episodes;
        }

        foreach ($episodes as $episode) {
            $episode['characters'] = json_decode($episode['characters']);
        }

        return $episodes;
    }

    /**
     * Return a episode by code
     */

    function getEpisodeByCode(string $code) {
       return  $this->model->where('cod_episode', $code)
        ->first();
    }

    /**
     * Create new episode
     */
    function postEpisode(array $episode) {
        $episode['characters'] = json_encode($episode['characters']);

        $this->model->create($episode);
    }

    function patchEpisode(array $episode, int $id) {

        $this->model->where('id', $id)
        ->first()
        ->fill($episode)
        ->save();
    }

    function delEpisode(int $id) {
        $episode = $this->model->find($id);

        if ($episode) {
            $episode->delete();
        }
    }

    function restoreEpisode(int $id) {
        $episode = $this->model->withTrashed()->find($id);

        if ($episode) {
            $episode->restore();
        }
    }

}
