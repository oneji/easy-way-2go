<?php

namespace App\Http\Services;

use App\HelpItem;
use App\Http\Requests\HelpItemRequest;

class HelpItemService
{
    /**
     * Get all items
     * 
     * @return collection
     */
    public function all()
    {
        return HelpItem::all();
    }
    
    /**
     * Get all items paginated
     * 
     * @return collection
     */
    public function getPaginated()
    {
        return HelpItem::paginate(10);
    }

    /**
     * Get by id
     * 
     * @param int $id
     */
    public function getById($id)
    {
        return HelpItem::find($id);
    }

    /**
     * Store a newly created item
     * 
     * @param \App\Http\Requests\HelpItemRequest $request
     */
    public function store(HelpItemRequest $request)
    {
        $item = new HelpItem($request->all());
        $item->save();
    }

    /**
     * Update an existing item
     * 
     * @param \App\Http\Requests\HelpItemRequest $request
     * @param int $id
     */
    public function update(HelpItemRequest $request, $id)
    {
        $item = HelpItem::find($id);
        $item->title = $request->title;
        $item->description = $request->description;
        $item->help_section_id = $request->help_section_id;
        $item->save();
    }

    /**
     * Delete item
     * 
     * @param int $id
     */
    public function delete($id)
    {
        $item = HelpItem::find($id);
        $item->deleted = 1;
        $item->save();
    }
}