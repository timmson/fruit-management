{if $smarty.request.mode eq "async" and $smarty.request.oper ne null}
    {include file="taskeditorasync.tpl"}
{else}
	{include file="taskeditorsync.tpl"}
{/if}


