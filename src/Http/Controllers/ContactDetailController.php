<?php

namespace Companue\Contacts\Http\Controllers;

use Companue\Contacts\Http\Requests\ContactDetailStoreRequest;
use Companue\Contacts\Models\ContactDetail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Companue\Contacts\Http\Resources\ContactDetailItem;

class ContactDetailController extends Controller
{
    public function index()
    {
        return response()->json([
            'contact_details' => ContactDetailItem::collection(ContactDetail::all())
        ]);
    }

    public function show($id)
    {
        $detail = ContactDetail::findOrFail($id);
        return response()->json([
            'contact_detail' => new ContactDetailItem($detail)
        ]);
    }

    public function store(ContactDetailStoreRequest $request)
    {
        $detail = ContactDetail::create($request->all());
        return response()->json([
            'message' => __('messages.recordـcreated_with_types', ['title' => $detail->id, 'type' => 'جزئیات مخاطب', 'titletype' => 'شماره']),
            'contact_detail' => new ContactDetailItem($detail)
        ]);
    }

    public function update(ContactDetailStoreRequest $request, $id)
    {
        $detail = ContactDetail::findOrFail($id);
        $detail->update($request->all());
        return response()->json([
            'message' => __('messages.record.updated_with_types', ['title' => $detail->id, 'type' => 'جزئیات مخاطب', 'titletype' => 'شماره']),
            'contact_detail' => new ContactDetailItem($detail)
        ]);
    }

    public function destroy($id)
    {
        $detail = ContactDetail::findOrFail($id);
        $detail->delete();
        return response()->json([
            'message' => __('messages.recordـdeleted_with_type', ['title' => $detail->id, 'type' => 'جزئیات مخاطب']),
        ]);
    }
}
