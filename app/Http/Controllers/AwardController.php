<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Song;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Awardable;
use Illuminate\Http\Request;

class AwardController extends Controller
{
    // Страница назначения наград
    public function AwardAssign($type, $id)
    {
        $awards = Award::all();
        $entity = null;

        switch($type) {
            case 'song':
                $entity = Song::with('artist')->findOrFail($id);
                break;
            case 'artist':
                $entity = Artist::findOrFail($id);
                break;
            case 'album':
                $entity = Album::with('artist')->findOrFail($id);
                break;
        }

        return view('award-assign', compact('entity', 'type', 'awards'));
    }

    // Сохранение награды
    public function AwardStore(Request $request)
    {
        $request->validate([
            'award_id' => 'required|exists:awards,id',
            'awardable_id' => 'required',
            'awardable_type' => 'required|in:App\Models\Song,App\Models\Artist,App\Models\Album',
            'year' => 'nullable|integer',
            'season' => 'nullable|string',
        ]);

        // Проверяем, не присвоена ли уже эта награда этой сущности
        $exists = Awardable::where('award_id', $request->award_id)
                           ->where('awardable_id', $request->awardable_id)
                           ->where('awardable_type', $request->awardable_type)
                           ->exists();

        if ($exists) {
            return back()->with('error', 'Эта награда уже присвоена данному объекту!');
        }

        $awardable = new Awardable;
        $awardable->award_id = $request->award_id;
        $awardable->awardable_id = $request->awardable_id;
        $awardable->awardable_type = $request->awardable_type;
        $awardable->awarded_at = $request->awarded_at ?? now();
        $awardable->year = $request->year;
        $awardable->season = $request->season;
        $awardable->save();

        return redirect()->back()->with('success', 'Награда успешно присвоена!');
    }

    // Удаление награды
    public function AwardRemove($id)
    {
        $awardable = Awardable::findOrFail($id);
        $awardable->delete();

        return redirect()->back()->with('success', 'Награда удалена!');
    }
}