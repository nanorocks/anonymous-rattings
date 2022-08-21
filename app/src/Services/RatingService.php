<?php

namespace App\Services;

use App\Exceptions\HttpException;
use App\Models\Rating;
use DI\Container;
use Rakit\Validation\Validator;
use Illuminate\Support\Collection;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface as Request;

class RatingService implements IRatingService
{

    public Validator $validator;

    public Logger $logger;

    public function __construct(Validator $validator, Container $container)
    {
        $this->validator = $validator;
        $this->logger = $container->get('logger');
    }

    /**
     * Load all ratings by slug name
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return Rating::selectRaw('slug, avg(rate) as total, count(slug) as quantity')
            ->groupBy(Rating::SLUG)
            ->orderBy('total', 'desc')
            ->get();
    }

    /**
     * Loading slinge slug with avg rating
     *
     * @param Request $request
     * @param [type] $args
     * @return Rating
     */
    public function rating(Request $request, $args): Rating
    {
        return Rating::where(Rating::SLUG, $args[Rating::SLUG])->selectRaw('slug, avg(rate) as total, count(slug) as quantity')
            ->groupBy(Rating::SLUG)
            ->orderBy('total', 'desc')
            ->first();
    }

    /**
     * Store unique rating per ip and slug only
     *
     * @param Request $request
     * @return Collection|null
     */
    public function store(Request $request): ?Collection
    {
        $body = json_decode($request->getBody(), true);

        $rating = Rating::where(Rating::IP, $body[Rating::IP])->where(Rating::SLUG, $body[Rating::SLUG])->first();

        if ($rating !== null) {
            $this->logger->info('STORE RATING HttpException ' . HttpException::ALREADY_EXIST . ' ALREADY_EXIST');
            throw HttpException::handle(HttpException::ALREADY_EXIST, $request);
        }

        $validate = $this->validator->validate($body, [
            Rating::SLUG => 'required',
            Rating::RATE => 'required|max:10|min:1',
            Rating::IP => 'required|ip',
        ]);

        if ($validate->fails()) {
            $this->logger->warning('STORE RATING $validate->fails()', $validate->errors()->firstOfAll());
            return new Collection([
                'rate' => null,
                'errors' => $validate->errors()->firstOfAll()
            ]);
        }

        return new Collection([
            'rate' => Rating::create([
                Rating::SLUG => $body[Rating::SLUG],
                Rating::IP => $body[Rating::IP],
                Rating::RATE => $body[Rating::RATE]
            ]),
            'errors' => null
        ]);
    }

    public function update(Request $request): ?Collection
    {

        $body = json_decode($request->getBody(), true) ?? [];

        $validate = $this->validator->validate($body, [
            Rating::SLUG => 'required',
            Rating::RATE => 'required|max:10|min:1',
            Rating::IP => 'required|ip',
        ]);

        if ($validate->fails()) {
            $this->logger->warning('UPDATE RATING $validate->fails()', $validate->errors()->firstOfAll());
            return new Collection([
                'rate' => null,
                'errors' => $validate->errors()->firstOfAll()
            ]);
        }
        
        $rating = Rating::where(Rating::IP, $body[Rating::IP])->where(Rating::SLUG, $body[Rating::SLUG])->first();

        if ($rating === null) {
            $this->logger->info('UPDATE RATING HttpException ' . HttpException::GONE . ' GONE');
            throw HttpException::handle(HttpException::GONE, $request);
        }

        $rating->rate = $body[Rating::RATE];

        $rating->save();

        return new Collection([
            'rate' => Rating::create([
                Rating::SLUG => $body[Rating::SLUG],
                Rating::IP => $body[Rating::IP],
                Rating::RATE => $body[Rating::RATE]
            ]),
            'errors' => null
        ]);
    }

    /**
     * Remove only existing rating by ip
     *
     * @param Request $request
     * @return Rating|null
     */
    public function remove(Request $request): ?Rating
    {
        $body = json_decode($request->getBody(), true) ?? [];

        $rating = Rating::where(Rating::IP, $body[Rating::IP])->first();

        if ($rating === null) {
            $this->logger->info('REMOVE RATING HttpException ' . HttpException::GONE . ' GONE');
            throw HttpException::handle(HttpException::GONE, $request);
        }

        $rating->delete();

        return $rating;
    }
}
