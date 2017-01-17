<h2>Проекты</h2>
<table class="container">
	<tr>
		<th>Проект</th>
		<th>График</th>
	</tr>
	{section name=i loop=$data}
   	<tr>
	    <td>[{$data[i].fm_name}]&nbsp;{$data[i].fm_descr}<br/>
		<a href="?dep=task&project={$data[i].id}">{$data[i].current_tasks}&nbsp;текущих задач</a><br/>
		Всего {$data[i].fm_spent_hours} потрачено часов
	    </td>	
	    <td>
		<img class="topup" width="400" height="150" src="?project={$data[i].id}&mode=async&oper=gif"/>
	    </td>
	</tr>
	{/section}
</table>

