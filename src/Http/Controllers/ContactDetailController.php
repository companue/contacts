<?php

namespace Companue\Contacts\Http\Controllers;

use Companue\Contacts\Http\Requests\ContactDetailStoreRequest;
use Companue\Contacts\Models\ContactDetail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Companue\Contacts\Http\Resources\ContactDetailItem;
use Illuminate\Support\Facades\Lang;

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
        $data = $request->all();
        // Ensure only one is_primary per contact_id
        if (!empty($data['is_primary']) && !empty($data['contact_id'])) {
            ContactDetail::where('contact_id', $data['contact_id'])->update(['is_primary' => false]);
            $data['is_primary'] = true;
        }
        $detail = ContactDetail::create($data);
        return response()->json([
            'message' => Lang::get('messages.recordـcreated', ['title' => __('contacts::terms.contact_detail')]),
            'contact_detail' => new ContactDetailItem($detail)
        ]);
    }

    public function update(ContactDetailStoreRequest $request, $id)
    {
        $detail = ContactDetail::findOrFail($id);
        $data = $request->except(['contact_id']);
        $contactId = $detail->contact_id;
        // Ensure only one is_primary per contact_id
        if (!empty($data['is_primary']) && $data['is_primary'] && !empty($contactId)) {
            ContactDetail::where('contact_id', $contactId)->where('id', '!=', $detail->id)->update(['is_primary' => false]);
            $data['is_primary'] = true;
        }
        $detail->update($data);
        return response()->json([
            'message' => Lang::get('messages.recordـupdated', ['title' => __('contacts::terms.contact_detail')]),
            'contact_detail' => new ContactDetailItem($detail)
        ]);
    }

    public function destroy($id)
    {
        $detail = ContactDetail::findOrFail($id);
        $detail->delete();
        return response()->json([
            'message' => Lang::get('messages.recordـdeleted', ['title' => __('contacts::terms.contact_detail')]),
        ]);
    }
}
