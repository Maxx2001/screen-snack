<?php

namespace App\Http\Controllers;

use JsonException;
use Inertia\Inertia;
use App\Models\User;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MediaResource;
use App\Http\Resources\StatusResource;
use Saloon\Exceptions\Request\RequestException;
use App\Http\Resources\MediaCollectionResource;
use Saloon\Exceptions\Request\FatalRequestException;
use App\Http\Intergrations\MoviesDatabase\Requests\GetMedia;
use App\Http\Intergrations\MoviesDatabase\Requests\GetSeries;
use App\Http\Intergrations\MoviesDatabase\MoviesDatabaseConnector;
use App\Http\Intergrations\MoviesDatabase\Requests\GetTopBoxoffice;

class MediaController extends Controller
{
    public MoviesDatabaseConnector $moviesDatabaseConnector;

    public function __construct()
    {
        $this->moviesDatabaseConnector = new MoviesDatabaseConnector();
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function show(string $mediaId): Response
    {
        $getMedia    = new GetMedia($mediaId);
        $media       = $this->moviesDatabaseConnector->send($getMedia)->object();
        $mediaStatus = null;

        /**
         * @var User $user
         * */
        if ($user = Auth::user()) {
            $mediaStatus = $user->getMediaStatus($media->results->id);
            $mediaStatus = $mediaStatus ? StatusResource::make($mediaStatus) : null;
        }

        return Inertia::render('Media/MediaShow',
            [
                'media'       => MediaResource::make($media->results),
                'mediaStatus' => $mediaStatus,
            ]
        );
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function series(): Response
    {
        $getSeries = new GetSeries();

        $series = $this->moviesDatabaseConnector->send($getSeries)->object();


        return Inertia::render('Media/MediaIndex',
            [
                'pageTitle'       => 'Series',
                'mediaCollection' => MediaCollectionResource::collection($series->results),
            ]
        );
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function topBoxoffice(): Response
    {
        $getTopBoxoffice = new GetTopBoxoffice();

        $topBoxoffice = $this->moviesDatabaseConnector->send($getTopBoxoffice)->object();

        return Inertia::render('Media/MediaIndex',
            [
                'pageTitle'       => 'Top Boxoffice',
                'mediaCollection' => MediaCollectionResource::collection($topBoxoffice->results),
            ]
        );
    }



    //    The API I was using for this project didn't return any movies.
    //    /**
    //     * @throws FatalRequestException
    //     * @throws RequestException
    //     * @throws JsonException
    //     */
    //    public function movies(): Response
    //    {
    //        $getMovies = new GetMovies();
    //
    //        $movies = $this->moviesDatabaseConnector->send($getMovies)->object();
    //
    //        return Inertia::render('MediaCollectionPage',
    //            [
    //                'pageTitle' => 'Movies',
    //                'mediaCollection' => $movies,
    //            ]
    //        );
    //    }
}
