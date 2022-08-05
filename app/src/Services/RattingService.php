<?php

namespace App\Services;

use App\Exceptions\HttpException;
use App\Models\Ratting;
use Rakit\Validation\Validator;
use Illuminate\Support\Collection;
use Psr\Http\Message\ServerRequestInterface as Request;

class RattingService implements IRattingService
{

    public Validator $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Load all ratings by slug name
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return Ratting::selectRaw('slug, avg(rate) as total, count(slug) as quantity')
            ->groupBy(Ratting::SLUG)
            ->orderBy('total', 'desc')
            ->get();
    }

    /**
     * Loading slinge slug with avg rating
     *
     * @param Request $request
     * @param [type] $args
     * @return Ratting
     */
    public function ratting(Request $request, $args): Ratting
    {
        return Ratting::where(Ratting::SLUG, $args[Ratting::SLUG])->selectRaw('slug, avg(rate) as total, count(slug) as quantity')
            ->groupBy(Ratting::SLUG)
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

        $ratting = Ratting::where(Ratting::IP, $body[Ratting::IP])->where(Ratting::SLUG, $body[Ratting::SLUG])->first();

        if ($ratting !== null) {
            throw HttpException::handle(HttpException::ALREADY_EXIST, $request);
        }

        $validate = $this->validator->validate($body, [
            Ratting::SLUG => 'required',
            Ratting::RATE => 'required|max:10|min:1',
            Ratting::IP => 'required|ip',
        ]);

        if ($validate->fails()) {
            return new Collection([
                'rate' => null,
                'errors' => $validate->errors()->firstOfAll()
            ]);
        }

        return new Collection([
            'rate' => Ratting::create([
                Ratting::SLUG => $body[Ratting::SLUG],
                Ratting::IP => $body[Ratting::IP],
                Ratting::RATE => $body[Ratting::RATE]
            ]),
            'errors' => null
        ]);
    }

    public function update(Request $request): ?Collection
    {

        $body = json_decode($request->getBody(), true);

        $validate = $this->validator->validate($body, [
            Ratting::SLUG => 'required',
            Ratting::RATE => 'required|max:10|min:1',
            Ratting::IP => 'required|ip',
        ]);

        if ($validate->fails()) {
            return new Collection([
                'rate' => null,
                'errors' => $validate->errors()->firstOfAll()
            ]);
        }
        
        $ratting = Ratting::where(Ratting::IP, $body[Ratting::IP])->where(Ratting::SLUG, $body[Ratting::SLUG])->first();

        if ($ratting === null) {
            throw HttpException::handle(HttpException::GONE, $request);
        }

        $ratting->rate = $body[Ratting::RATE];

        $ratting->save();

        return new Collection([
            'rate' => Ratting::create([
                Ratting::SLUG => $body[Ratting::SLUG],
                Ratting::IP => $body[Ratting::IP],
                Ratting::RATE => $body[Ratting::RATE]
            ]),
            'errors' => null
        ]);
    }

    /**
     * Remove only existing ratting by ip
     *
     * @param Request $request
     * @return Ratting|null
     */
    public function remove(Request $request): ?Ratting
    {
        $body = json_decode($request->getBody(), true) ?? [];

        $ratting = Ratting::where(Ratting::IP, $body[Ratting::IP])->first();

        if ($ratting === null) {
            throw HttpException::handle(HttpException::GONE, $request);
        }

        $ratting->delete();

        return $ratting;
    }
}
