<div class="authorInfo">

<!--<p><?php echo $this->lang->en('Author')?>,</p>-->
<h3><?php echo $me['user_screenname']?></h3>

<div class="flags">
    <?php echo $this->lang->en('Cambiar Idioma')?>
    <img <?php if ($me['con']['lang'] != 'es'):?> style="opacity:.30; filter:alpha(opacity=30);"<?php endif;?>
        data-language="es" class="langBtn" src="/wwwroot/images/Colombia_24x24-32.png" />
    <img <?php if ($me['con']['lang'] != 'en'):?> style="opacity:.30; filter:alpha(opacity=30);"<?php endif;?>
        data-language="en" class="langBtn" src="/wwwroot/images/United-States_24x24-32.png" />
</div>

</div>

<form id="langForm" name="langForm" action='/lenguaplus' method='GET'>
<div class="controllers">
        <ul>
            <li>
                <!--<label><?php echo $this->lang->en('Filters')?></label>
                <select id="groupbySel" class="langFilter" name='groupby[]'>
                    <option value=''><?php echo $this->lang->en('No Groupings')?></option>
                    <option <?php if(in_array('key', $qparams['groupby'])):?>selected='selected'<?php endif;?> value='key'><?php echo $this->lang->en('Key')?></option>
                    <option <?php if(in_array('url', $qparams['groupby'])):?>selected='selected'<?php endif;?> value='url'>URL</option>
                    <option <?php if(in_array('file', $qparams['groupby'])):?>selected='selected'<?php endif;?> value='file'><?php echo $this->lang->en('File')?></option>
                    <option <?php if(in_array('file,line', $qparams['groupby'])):?>selected='selected'<?php endif;?> value='file,line'><?php echo $this->lang->en('File')?> &amp; <?php echo $this->lang->en('Line')?></option>
                    <option <?php if(in_array('status', $qparams['groupby'])):?>selected='selected'<?php endif;?> value='status'><?php echo $this->lang->en('Status')?></option>
                </select>-->
            </li>
            <li>
                <select class="langFilter" name='status' id='statusSel'>
                    <option value=""><?php echo $this->lang->en('Any Status')?></option>
                    <?php foreach(array('debug','edited','live','deleted','propername') as $status):?>
                        <option <?php if($qparams['status'] == $status):?>selected='selected'<?php endif;?> value='<?php echo $status?>'><?php echo ucwords($this->lang->msg($status))?></option>
                    <?php endforeach;?>
                </select>
            </li>
            <li>
                <select class="langFilter" name='type' id="typeSel">
                    <option value=''><?php echo $this->lang->en('Any Type')?></option>
                    <option <?php if($qparams['type'] == 'msg'):?>selected='msg'<?php endif;?> value='msg'><?php echo $this->lang->en('Messages')?></option>
                    <option <?php if($qparams['type'] == 'ugc'):?>selected='ugc'<?php endif;?> value='ugc'><?php echo $this->lang->en('User Generated Content')?></option>
                </select>
            </li>
            <li>
                <button id="publishBtn"><?php echo $this->lang->msg('Publish')?></button>
            </li>
        </ul>
</div>

<table class="tablesorter lang_table">
    <caption style='text-align:right'>

            <?php $from = ($qparams['from'] > 0) ? $qparams['from'] : 0;  ?>
            <?php $want = ($qparams['want'] > 0) ? $qparams['want'] : 30;  ?>

        <?php if ($totalTexts > count($texts)):?>
            <?php if($from > 0):?>
                <a style='margin-right:6px' href='/lenguaplus?from=<?php echo $from-$want?><?php foreach($qparams as $key=>$para):?><?php if($key!='want' && $key!='from'&&!empty($para)):?>&<?php echo $key?>=<?php echo (is_array($para)?implode(',',$para):$para)?><?php endif?><?php endforeach?>'
                   onclick='this.href+="&want="+$("#wantPagePer").val()'
                   id='nextBtn'><?php echo $this->lang->es('Atras')?></a>
            <?php endif?>
            <?php $from = ($from + $want > $totalTexts) ? $totalTexts : $from + $want; ?>
            <?php if($from > 0 && $from < $totalTexts):?>
                ...
            <?php endif?>
            <?php if($from < $totalTexts):?>
                <a style='margin-right:6px' href='/lenguaplus?from=<?php echo $from?><?php foreach($qparams as $key=>$para):?><?php if($key!='want' && $key!='from'&&!empty($para)):?>&<?php echo $key?>=<?php echo (is_array($para)?implode(',',$para):$para)?><?php endif?><?php endforeach?>'
                   onclick='this.href+="&want="+$("#wantPagePer").val()'
                    id='backBtn'><?php echo $this->lang->es('Siguente')?></a>
            <?php endif?>

            <span style='line-height:30px;'>
            <select style='width:55px' id="wantPagePer" >
                <?php foreach(array('30','50','100','200','300') as $wt):?>
                    <option
                        <?php if ($want == $wt):?>selected='selected'<?php endif?>
                        value='<?php echo $wt?>'><?php echo $wt?></option>
                <?php endforeach;?>
            </select>
            <?php echo $this->lang->en('of')?> <?php echo $totalTexts?>
            </span>
        <?php else:?>
            <?php echo $totalTexts?> <?php echo $this->lang->es('filas')?>
        <?php endif?>
    </caption>
    <thead>
        <tr>
            <?php foreach ($headers as $key=>$head): ?>
                <th class="<?php echo  $key ?> <?php echo ($key == "langtracker_status") ? 'nosort' : '';?>"  >
                <?php if ($key == "langtracker_es"):?>
                <?php echo  $this->lang->key($head);?>
                <img src="/wwwroot/images/Colombia_16x16-32.png" />
                <?php elseif ($key == "langtracker_en"):?>
                <?php echo  $this->lang->key($head);?>
                <img src="/wwwroot/images/United-States_16x16-32.png" />
                <?php elseif ($key == "langtracker_status"):?>
                    <select style='width: 100%;margin: 0;float: left;' id="allStatusChanger" >
                    <option value=''><?php echo $this->lang->es('Cambiar todos campos')?></option>
                    <?php foreach(array('debug','edited','live','deleted','propername') as $status):?>
                        <option value='<?php echo $status?>'><?php echo ucwords($this->lang->msg($status))?></option>
                    <?php endforeach;?>
                    </select>
                <?php else:?>
                <?php echo  $this->lang->key($head);?>
                <?php endif;?>
                </th>

            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody id="tableBody">
        <?php $rowNum=0; ?>
        <?php foreach ($texts as $text): ?>
            <tr class="<?php echo ($rowNum&1) ? 'odd' : 'even'?> langRow" data-langid='<?php echo $text->langtracker_id?>' id='langtracker_<?php echo $text->langtracker_id?>' >
                <?php foreach ($headers as $key=> $head): ?>
                        <td class="langtracker <?php echo  $key ?>" >
                        <?php if ($key == "langtracker_status"):?>
                            <select name='statusChange' data-langid="<?php echo $text->langtracker_id?>" >
                                <?php foreach(array('debug','edited','live','deleted','propername') as $status):?>
                                    <option <?php if($text->$key == $status):?>selected='selected'<?php endif;?> value='<?php echo $status?>'><?php echo ucwords($this->lang->msg($status))?></option>
                                <?php endforeach;?>
                            </select>
                            <button class="updateLang" title='<?php echo $this->lang->en('update')?> <?php echo (isset($text->count)) ? $text->count : ''?>' ><?php echo $this->lang->en('update')?> <?php echo (isset($text->count) && $text->count > 1) ? $text->count : ' #'.$text->langtracker_id?></button>
                        <?php elseif ($key == "langtracker_key"):?>
                            <?php echo  ellipse($text->$key, 30) ?>
                        <?php elseif ($key == "langtracker_urls"):?>
                            <?php $urls = explode(',',$text->langtracker_urls); $dups = array(); ?>
                            <?php foreach ($urls as $url):?>
                                <?php if(!isset($dups[$url])):?>
                                    <a href="http://<?php echo $text->langtracker_host . $url?>" target="_blank"><?php echo $url?></a>
                                    <?php $dups[$url] = true; ?>
                                <?php endif;?>
                            <?php endforeach;?>
                        <?php elseif ($key == "langtracker_updated"):?>
                                    <?php echo $text->langtracker_updated?>
                        <?php elseif ($key == "langtracker_es" || $key == "langtracker_en"):?>
                            <?php // if ($text->langtracker_type == 'ugc' && substr($key, strpos($key, "_")+1) == $text->langtracker_language):?>
                                <textarea name="<?php echo substr($key, strpos($key, "_")+1).'_'.$text->langtracker_id?>"
                                          data-langid="<?php echo $text->langtracker_id?>"
                                          data-language="<?php echo substr($key, strpos($key, "_")+1)?>"
                                          ><?php echo $text->$key?></textarea>
                        <?php elseif ($key == "langtracker_file"):?>
                            <span title="<?php echo $text->$key?>"><?php echo  ellipse(str_replace(ROOT_CD, '', $text->$key), -20)?></span>
                        <?php else:?>
                            <?php echo  (!isset($text->$key) || empty($text->$key)) ? "" : $text->$key ?>
                        <?php endif;?>
                        </td>
                <?php endforeach; ?>
            </tr>
        <?php $rowNum++; endforeach; ?>
    </tbody>
</table>
</form>
