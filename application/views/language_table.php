<script type="text/javascript" src="<?=IDI_HTTP?>wwwroot/js/jquery.tablesorter.min.js?v=1358932174"></script>          
<style type="text/css">
.master, .widescreen .master, .narrowscreen .master { width:100%!important; max-width:100%!important;}

table .header { width:auto; } /* very different elements */

body, #backSplash { font-family:Calibri, Arial, Sans-Serif; }
table a, table a:visited, table .alink { color:#5B74AB; }

/* tables */
table.tablesorter {
	font-family:arial;
	background-color: #CDCDCD;
	margin:10px 0 15px 0;
	font-size: 8pt;
	width: 100%;
	text-align: left;
        position: relative;        
}
table.tablesorter thead tr th, table.tablesorter tfoot tr th {
	background-color: #e6EEEE;
	border: 1px solid #FFF;
	font-size: 8pt;
	padding: 4px;
}
table.tablesorter thead tr .header {
	background-image: url(<?=IDI_HTTP?>wwwroot/img/bg.gif);
	background-repeat: no-repeat;
	background-position: center right;
        float:none;
	cursor: pointer;
}
table.tablesorter tbody td {
	color: #3D3D3D;
	padding: 4px;
	background-color: #FFF;
	vertical-align: top;
}
table.tablesorter tbody tr.odd td {
	background-color:#F0F0F6;
}

table.tablesorter thead tr .headerSortUp {
	background-image: url(<?=IDI_HTTP?>wwwroot/img/asc.gif);
}
table.tablesorter thead tr .headerSortDown {
	background-image: url(<?=IDI_HTTP?>wwwroot/img/desc.gif);
}
table.tablesorter thead tr .headerSortDown, table.tablesorter thead tr .headerSortUp {
background-color: #8dbdd8;
}
.tablesorter p { margin:0; }

td.metrics, td.dimensions { word-wrap:break-word; max-width:300px}
th.widget_name, td.widget_name { min-width:165px; }

</style>

<form action='' method='GET'>    
    <select name='groupby[]'>
        <option value='key'>Key</option>
        <option value='url'>URL</option>
        <option value='file'>File</option>
        <option value='file,line'>File & Line</option>
        <option value='status'>Status</option>
    </select>
    <select name='status'>
        <option value=''>Any</option>
        <option value='debug'>Debug</option>
        <option value='edited'>Editted</option>
        <option value='edited'>Live</option>
    </select>
    <input type='submit' class="btn btn-small"  value='<?=$this->lang->line('submit')?>' />
</form>


<table class="tablesorter">
    <thead><tr>
            <? foreach ($headers as $key=>$head): ?>
                <th class="<?= $key ?>"><?= $head ?></th>
            <? endforeach; ?>
        </tr></thead>    
    <tbody id="tableBody">
        <? foreach ($texts as $text): ?>
            <tr>
                <? foreach ($headers as $key=> $head): ?>
                        <td class="langtracker <?= $key ?>" id='langtracker_<?=$text->langtracker_id?>' >    
                        <?if ($key == "langtracker_key"):?>
                            <span title='<?=$this->lang->line('update')?>' class='idIcons grayReload'></span>
                            <?= $text->$key ?>
                        <?elseif ($key == "langtracker_url"):?>
                            <a href="http://<?=$text->langtracker_host . $text->langtracker_url?>" target="_blank"><?=$text->langtracker_url?></a>
                        <?elseif ($key == "langtracker_added"):?>
                            <?=fDate($text->$key, 'sortershort')?>
                        <?elseif ($key == "langtracker_es" || $key == "langtracker_en"):?>
                            <input name="<?=$key?>" value='<?=$text->$key?>' />
                        <?elseif ($key == "langtracker_file"):?>
                            <span title="<?=$text->$key?>"><?= ellipse(str_replace(ROOT_CD, '', $text->$key), -20)?></span>
                        <?else:?>
                            <?= (!isset($text->$key) || empty($text->$key)) ? "" : $text->$key ?>
                        <?endif;?>
                        </td>
                <? endforeach; ?>
            </tr>
        <? endforeach; ?>
    </tbody>
</table>
        <script language="javascript" type="text/javascript">
            $(document).ready(function(){
                $(".tablesorter").tablesorter({widgets: ['zebra']});
            });
        </script>       