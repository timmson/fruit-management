{section name=i loop=$release}
	{if $smarty.request.release eq $release[i].id}
		{assign var="currelease"  value=$release[i]}
	{/if}
{/section}
<h2 style="text-align:center">RBRU Software Product Release Notes</h2>
<h3 style="text-align:center">Software: Some software</h3>
<h4 style="font-size:13pt;">Delivery date:&nbsp;{$smarty.now|date_format:$const.global.dateformat}</h4>
<h4 style="font-size:13pt;">Release Date:&nbsp;{$smarty.now|date_format:$const.global.dateformat}</h4>
<h4 style="font-size:13pt;">Release Version:&nbsp;{$currelease.fm_code}</h4>
<h4 style="font-size:13pt;">Release Old Version:&nbsp;<span style="color:red">REQUIRED</span></h4>
<br/>
<h4 style="font-size:13pt;">Overview</h4>
<p>{$currelease.fm_descr}</p>
<h4 style="font-size:13pt;">New functionality /infill obligatory for business functionality changes/:</h4>
<h4 style="font-size:13pt;">Defect fixing /infill obligatory for fixing releases/:</h4>
<h4 style="font-size:13pt;">Known issues/problems /infill optional/:</h4>
<h4 style="font-size:13pt;">End-user Impact /infill obligatory/:</h4>
<h4 style="font-size:13pt;">Support Impacts /infill obligatory/:</h4>
<h4 style="font-size:13pt;">Contacts /infill obligatory/:</h4>
<p><span style="text-decoration:underline; font-weight:bold;">Note</span>: The New functionality, Defect fixing, Known issues/problems, End-user Impact, Support Impacts sections have to include list of new functionality, defects, issues, impacts from previous release notice if testing of previous release was not completed before new release was delivered.</p>
<h4 style="font-size:13pt;">Release contents /infill obligatory/:</h4>
<h4 style="font-size:13pt;">Documentation contents /infill obligatory/:</h4>
<table class="container" width="100%">
	<tr style="background:#999">
		<th>Document name</th>
		<th>Document Release date</th>
		<th>Version</th>
		<th>File Name path</th>
		<th>Comments /optional/</th>
	</tr>
	<tr>
		<td>Installation Guide</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Administration Guide</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Technical Requirements Specification</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>		
</table>
