<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUrlRequest;
use App\Http\Requests\UpdateUrlRequest;
use App\Models\Url;
use App\Models\UrlLinks;
use DOMDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $urls = Url::where('user_id', $request->get('userId'))->get();
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json('Unable to list Urls. Try later!', 400);
        }

        return response()->json($urls);
    }

    /**
     * Store a new resource.
     */
    public function store(StoreUrlRequest $request): JsonResponse
    {
        try {
            $url = Url::create([
                'name' => $request->get('name'),
                'url' => $request->get('url'),
                'user_id' => $request->get('userId')
            ]);

            $createLinks = [];
            $html = file_get_contents($request->get('url'));
            $dom = new DomDocument();
            @$dom->loadHTML($html);
            $links = $dom->getElementsByTagName('a');

            foreach ($links as $link) {
                $createLinks[] = [
                    'link_id' => $url->id,
                    'link' => $link->getAttribute('href'),
                    'name' => $request->get('name'). ' ' . $link->getAttribute('href')
                ];
            }

            $url->links()->createMany($createLinks);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json('Unable to create an Url. Try later!', 400);
        }

        return response()->json(Url::find($url->id), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $result = Url::find($id);
        } catch (\Exception $e) {
            Log::error("Url not found: ", ['errors' => $e]);
            return response()->json("Url not found", 404);
        }

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     */
    public function showUrlWithLinks(string $id): JsonResponse
    {
        try {
            $result = Url::find($id)->links;
        } catch (\Exception $e) {
            Log::error("Url not found with details: ", ['errors' => $e]);
            return response()->json("Url not found", 404);
        }

        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUrlRequest $request, string $id): JsonResponse
    {
        try {
            Url::find($id)->update([
                'name' => $request->get('name'),
                'url' => $request->get('url'),
                'user_id' => $request->get('userId')
            ]);

            $updateUrl = [];
            $html = file_get_contents($request->get('url'));
            $dom = new DomDocument();
            @$dom->loadHTML($html);
            $urls = $dom->getElementsByTagName('a');

            foreach ($urls as $url) {
                $updateUrl[] = [
                    'url_id' => $id,
                    'link' => $url->getAttribute('href'),
                    'name' => $request->get('name'). ' ' . $url->getAttribute('href')
                ];
            }

            UrlLinks::upsert($updateUrl, ['url_id'], ['link', 'name']);
        } catch (\Exception $e) {
            Log::error("Unable to update Url with details: ", ['errors' => $e]);
            return response()->json("Unable to update Url", 400);
        }

        return response()->json(Url::find($id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            Url::destroy($id);
        } catch (\Exception $e) {
            Log::error("Unable to delete an Url with details: ", ['errors' => $e]);
            return response()->json("Unable to delete an Url", 400);
        }

        return response()->json("Url deleted successfully");
    }
}
