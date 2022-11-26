{assign var="w" value=$sections|@count}
{math equation="round(100/$w)" assign="w"}
<table cellpadding="5" width="100%" class="plain">
    <tr>
        {section name=i loop=$sections}
            <td align="center" style="border:0px; width:{$w}%;">
                <a {if $sections[i].name eq $currentSection}
                    class="cur"
                {else}
                    class="av"
                {/if}
                        href="?section={$sections[i].name}">
                    <img src="{$factory->img_admin_dir}{$sections[i].icon}" alt="{$sections[i].name}"/>
                    <br/>
                    {$sections[i].description}
                </a>
            </td>
        {/section}
    </tr>
</table>
