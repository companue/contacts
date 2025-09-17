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
        $detail = ContactDetail::create($request->all());
        return response()->json([
            'message' => Lang::get('messages.recordـcreated', ['title' => __('contacts::terms.contact_detail')]),
            'contact_detail' => new ContactDetailItem($detail)
        ]);
    }

    public function update(ContactDetailStoreRequest $request, $id)
    {
        $detail = ContactDetail::findOrFail($id);
        $detail->update($request->all());
        return response()->json([
            'message' => Lang::get_('messages.recordـupdated', ['title' => __('contacts::terms.contact_detail')]),
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
