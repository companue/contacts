<?php

namespace Companue\Contacts;

class Contacts
{
    function installed()
    {
        return 'OK';
    }

    function version()
    {
        $content = file_get_contents(base_path('composer.json'));
        $content = json_decode($content, true);
        $version = $content["require"]["companue/contacts"];

        return $version;
    }
}
