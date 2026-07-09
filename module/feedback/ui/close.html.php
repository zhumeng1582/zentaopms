<?php
declare(strict_types=1);

namespace zin;

modalHeader(set::title($lang->feedback->close));

formPanel
(
    set::submitBtnText($lang->feedback->close),
    formGroup
    (
        set::width('1/2'),
        set::name('closedReason'),
        set::label($lang->feedback->closedReason),
        set::control('picker'),
        set::items($lang->feedback->closedReasonList),
        set::value('done')
    ),
    formGroup
    (
        set::label($lang->feedback->comment),
        editor(set::name('comment'), set::rows(5))
    )
);
hr();
history(set::objectID($feedback->id));

render();
