<?php

namespace XternalSoft\NovaEloquentTaggableField\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TagFieldController extends Controller
{
    public function index(Request $request)
    {
        $query = Tag::query();
        if ($request->has('filter.containing')) {
            $query->where('normalized', 'like', '%' . strtolower($request['filter']['containing']) . '%');
        }

        if ($request->has('limit')) {
            $query->limit($request['limit']);
        }
        $query->orderBy('normalized');
        return $query->get()->map(
            static function (Tag $tag) {
                return $tag->name;
            }
        );
    }
}
