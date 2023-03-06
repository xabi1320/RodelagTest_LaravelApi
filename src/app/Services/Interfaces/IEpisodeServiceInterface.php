<?php

namespace App\Services\Interfaces;

interface IEpisodeServiceInterface
{
    /**
     * @return array
     */
    function getEpisodes();

    /**
     * @param int $code
     * @return episode
     */

    function getEpisodeByCode(string $code);

    /**
     * @param array $episode
     * @return void
     */

    function postEpisode(array $episode);

    /**
     * @param array $episode
     * @param int $id
     * @return void
     */

    function patchEpisode(array $episode, int $id);

    /**
     * @param int $id
     * @return boolean
     */

    function delEpisode(int $id);

    /**
     *   @param int $id
     *   @return boolean
     */


    function restoreEpisode(int $id);
}
