<?php

namespace Companue\Contacts\Http\Controllers;

use Companue\Contacts\Http\Requests\ContactStoreRequest;
use Companue\Contacts\Models\Contact;
use Illuminate\Http\Request;
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
        return Response::json([
            'contacts' => ContactDisplayItem::collection($contacts)
        ]);
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return Response::json([
            'contact' => new ContactDisplayItem($contact)
        ]);
    }

    public function store(ContactStoreRequest $request)
    {
        // $contact = Contact::create($request->all());
        // return Response::json([
        //     'message' => Lang::get('messages.recordـcreated_with_types', ['title' => $contact->id, 'type' => 'مخاطب', 'titletype' => 'شماره']),
        //     'contact' => new ContactItem($contact)
        // ]);

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
            'message' => Lang::get('messages.recordـcreated_with_types', ['title' => $contact->id, 'type' => 'مخاطب', 'titletype' => 'شماره']),
            'contact' => new ContactDisplayItem($contact)
        ]);
    }

    public function update(ContactStoreRequest $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update($request->all());
        return Response::json([
            'message' => Lang::get('messages.record.updated_with_types', ['title' => $contact->id, 'type' => 'مخاطب', 'titletype' => 'شماره']),
            'contact' => new ContactItem($contact)
        ]);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return Response::json([
            'message' => Lang::get('messages.recordـdeleted_with_type', ['title' => $contact->id, 'type' => 'مخاطب']),
        ]);
    }
}
