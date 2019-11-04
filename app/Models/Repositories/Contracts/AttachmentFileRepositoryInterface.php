<?php

namespace App\Models\Repositories\Contracts;

interface AttachmentFileRepositoryInterface {

    public function create($data = array());

    public function delete($id);

    public function assignToAttachment($attachment_id, $new_attachment = []);
}
