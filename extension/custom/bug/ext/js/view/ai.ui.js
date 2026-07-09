(function()
{
    function escapeHtml(text)
    {
        return String(text || '').replace(/[&<>"']/g, function(char)
        {
            return {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'}[char];
        });
    }

    function createPanel()
    {
        var $panel = $('#zentao-ai-bug-panel');
        if($panel.length) return $panel;

        $panel = $('<div id="zentao-ai-bug-panel" class="zentao-ai-panel"></div>');

        var $stepsCard = $('.detail-content .panel, #mainContent .panel, #mainContent .cell, #mainContent section').first();
        if($stepsCard.length) $stepsCard.before($panel);
        else $('#mainContent').prepend($panel);

        return $panel;
    }

    function renderAIResult(data)
    {
        createPanel().removeClass('hidden').html(
            '<div class="zentao-ai-panel-title">AI 分析结果</div>' +
            '<div class="zentao-ai-panel-body">' +
                '<div><strong>摘要：</strong>' + escapeHtml(data.summary) + '</div>' +
                '<div><strong>建议优先级：</strong>' + escapeHtml(data.suggestedPriority) + '</div>' +
                '<div><strong>风险等级：</strong>' + escapeHtml(data.riskLevel) + '</div>' +
                '<div class="muted">当前为最小扩展示例，后续会接入独立 AI 服务。</div>' +
            '</div>'
        );
    }

    function analyzeBug($trigger)
    {
        if(typeof bugID === 'undefined') return;

        var $btn = $trigger instanceof jQuery ? $trigger : $($trigger);
        var oldHtml = $btn.html();
        var link = typeof aiAnalyzeLink !== 'undefined' ? aiAnalyzeLink : $.createLink('bug', 'aiAnalyze', 'bugID=' + bugID);

        $btn.prop('disabled', true).addClass('disabled').text('AI 分析中...');
        createPanel().html('AI 分析中...');

        $.getJSON(link, function(response)
        {
            if(response && response.result === 'success') renderAIResult(response.data || {});
            else createPanel().html(response && response.message ? escapeHtml(response.message) : 'AI 分析失败');
        }).fail(function()
        {
            createPanel().html('AI 分析请求失败');
        }).always(function()
        {
            $btn.prop('disabled', false).removeClass('disabled').html(oldHtml || '<i class="icon icon-magic"></i> AI 分析');
        });
    }

    $(document).on('click', '.zentao-ai-analyze-action', function(event)
    {
        event.preventDefault();
        analyzeBug($(this));
    });
})();
