<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Lab Http Controller to Mock the Response to fulfill requests from findlab.
 */
class LabController extends Controller
{
    const LAB_FIXTURE = 'html/fixtures/base/labs.json';

    /** @var array Default labs */
    protected $labs;

    /** @var array Default coordination */
    protected $coord = [
        'latitude'  => '30.0487594604',
        'longitude' => '-95.2193298340',
    ];

    /** @var array Default time zone information */
    protected $tzInfo = [
        'dstOffset' => 3600,
        'rawOffset' => -18000,
        'status' => 'OK',
        'timeZoneId' => "America\/New_York",
        'timeZoneName' => 'Eastern Daylight Time',
    ];

    public function __construct()
    {
        $this->labs = $this->loadLabs();
    }

    /**
     * Return the lab search result.
     *
     * @param Request $request http request
     *
     * @return Response
     */
    public function labsNearPostalCode(Request $request)
    {
        return response()->json(
            array_merge([
                'labs'        => $this->labs,
                'resultCount' => count($this->labs),
                'tzInfo'      => $this->tzInfo,
            ], $this->coord)
        );
    }

    /**
     * Return the geocoding result.
     *
     * @param Request $request http request
     *
     * @return Response
     */
    public function geocode(Request $request)
    {
        return response()->json([array_merge($this->coord, ['countryCode' => 'US'])]);
    }

    /**
     * Return the phlebotomist search result.
     *
     * @param Request $request http request
     *
     * @return mixed
     */
    public function phlebotomistsNearCoords(Request $request)
    {
        return response()->json(['hasPhlebotomists' => true]);
    }

    /**
     * Load and parse the default labs.
     *
     * @return array
     */
    protected function loadLabs()
    {
        $content = file_get_contents(base_path(static::LAB_FIXTURE));

        return json_decode($content);
    }
}
