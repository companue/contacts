<?php

namespace Companue\Contacts\Http\Controllers;

use Companue\Contacts\Http\Requests\ContactStoreRequest;
use Companue\Contacts\Http\Resources\ContactDetailItem;
use Companue\Contacts\Models\Contact;
use Illuminate\Routing\Controller;
use Companue\Contacts\Http\Resources\ContactDisplayItem;
use Companue\Contacts\Http\Resources\ContactItem;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Response;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return Response::json(ContactDisplayItem::collection($contacts));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return Response::json([
            'contact' => new ContactDisplayItem($contact)
        ]);
    }

    public function details($id)
    {
        $contact = Contact::findOrFail($id);
        return response()->json([
            'contact_details' => ContactDetailItem::collection($contact->details)
        ]);
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return Response::json([
            'contact' => new ContactItem($contact)
        ]);
    }

    public function store(ContactStoreRequest $request)
    {

        $data = $request->all();
        $details = $data['contact_details'] ?? null;
        unset($data['contact_details']);

        $contact = Contact::create($data);

        if ($details) {
            foreach ($details as $detail) {
                $contact->details()->create($detail);
            }
        }

        return Response::json([
            'message' => Lang::get('messages.recordـcreated', ['title' => $contact->label]),
            'contact' => new ContactDisplayItem($contact)
        ]);
    }

    public function update(ContactStoreRequest $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update($request->all());
        return Response::json([
            'message' => Lang::get('messages.recordـupdated', ['title' => $contact->label]),
            'contact' => new ContactDisplayItem($contact)
        ]);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return Response::json([
            'message' => Lang::get('messages.recordـdeleted', ['title' => $contact->label]),
        ]);
    }
}
