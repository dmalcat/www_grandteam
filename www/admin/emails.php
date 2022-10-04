<?php

if ($par_3 == "delete" && $par_4) {
    dbI::query("DELETE FROM s3n_emails WHERE id = %i", $par_4)->result();
    Message::success("Email byl odebrán", "/admin/emails");
}
?>