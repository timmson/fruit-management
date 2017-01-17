{assign var="w" value=$deps|@count}
{math equation="round(100/$w)" assign="w"}
<table cellpadding="5" width="100%" class="plain">
	<tr>
   {section name=i loop=$deps}
    <td align="center" style="border:0px; width:{$w}%;">
        <a {if $deps[i].access eq 0}
              {if $deps[i].name eq $dep}
		            class="cur" href="?dep={$deps[i].name}"
             {else}
                 class="av" href="?dep={$deps[i].name}"
   			      {/if}
         {else}
  		       class="unav" href="javascript:help('{$const.mail.webmaster}')"
         {/if}><img src="{$factory->img_admin_dir}{$deps[i].icon}" alt="{$deps[i]._name}"/>
         <br/>
        {$deps[i].descr}
         </a>
		</td>
	{/section}
	</tr>
</table>
