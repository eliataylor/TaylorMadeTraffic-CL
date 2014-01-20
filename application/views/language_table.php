<div class="authorInfo">

<!--<p><?=$this->lang->en('Author')?>,</p>-->
<h3><?=$me['user_screenname']?></h3>

<div class="flags">
    <?=$this->lang->en('Cambiar Idioma')?>
    <img <?if ($me['con']['lang'] != 'es'):?> style="opacity:.30; filter:alpha(opacity=30);"<?endif;?>
        data-language="es" class="langBtn" src="/wwwroot/images/Colombia_24x24-32.png" />
    <img <?if ($me['con']['lang'] != 'en'):?> style="opacity:.30; filter:alpha(opacity=30);"<?endif;?>
        data-language="en" class="langBtn" src="/wwwroot/images/United-States_24x24-32.png" />
</div>
    
</div>

<form id="langForm" name="langForm" action='/lenguaplus' method='GET'>    
<div class="controllers">
        <ul>
            <li>
                <!--<label><?=$this->lang->en('Filters')?></label>
                <select id="groupbySel" class="langFilter" name='groupby[]'>
                    <option value=''><?=$this->lang->en('No Groupings')?></option>
                    <option <?if(in_array('key', $qparams['groupby'])):?>selected='selected'<?endif;?> value='key'><?=$this->lang->en('Key')?></option>
                    <option <?if(in_array('url', $qparams['groupby'])):?>selected='selected'<?endif;?> value='url'>URL</option>
                    <option <?if(in_array('file', $qparams['groupby'])):?>selected='selected'<?endif;?> value='file'><?=$this->lang->en('File')?></option>
                    <option <?if(in_array('file,line', $qparams['groupby'])):?>selected='selected'<?endif;?> value='file,line'><?=$this->lang->en('File')?> &amp; <?=$this->lang->en('Line')?></option>
                    <option <?if(in_array('status', $qparams['groupby'])):?>selected='selected'<?endif;?> value='status'><?=$this->lang->en('Status')?></option>
                </select>-->
            </li>
            <li>                
                <select class="langFilter" name='status' id='statusSel'>
                    <option value=""><?=$this->lang->en('Any Status')?></option>
                    <?foreach(array('debug','edited','live','deleted','propername') as $status):?>
                        <option <?if($qparams['status'] == $status):?>selected='selected'<?endif;?> value='<?=$status?>'><?=ucwords($this->lang->msg($status))?></option>
                    <?endforeach;?>
                </select>                     
            </li>
            <li>                
                <select class="langFilter" name='type' id="typeSel">
                    <option value=''><?=$this->lang->en('Any Type')?></option>
                    <option <?if($qparams['type'] == 'msg'):?>selected='msg'<?endif;?> value='msg'><?=$this->lang->en('Messages')?></option>
                    <option <?if($qparams['type'] == 'ugc'):?>selected='ugc'<?endif;?> value='ugc'><?=$this->lang->en('User Generated Content')?></option>
                </select>
            </li>
            <li>                
                <button id="publishBtn"><?=$this->lang->msg('Publish')?></button>
            </li>
        </ul>
</div>

<table class="tablesorter lang_table">
    <caption style='text-align:right'>
        
            <?php $from = ($qparams['from'] > 0) ? $qparams['from'] : 0;  ?>
            <?php $want = ($qparams['want'] > 0) ? $qparams['want'] : 30;  ?>
            
        <? if ($totalTexts > count($texts)):?>
            <? if($from > 0):?>
                <a style='margin-right:6px' href='/lenguaplus?from=<?=$from-$want?><?foreach($qparams as $key=>$para):?><?if($key!='want' && $key!='from'&&!empty($para)):?>&<?=$key?>=<?=(is_array($para)?implode(',',$para):$para)?><?endif?><?endforeach?>' 
                   onclick='this.href+="&want="+$("#wantPagePer").val()'
                   id='nextBtn'><?=$this->lang->es('Atras')?></a>
            <?endif?>
            <?php $from = ($from + $want > $totalTexts) ? $totalTexts : $from + $want; ?>                        
            <? if($from > 0 && $from < $totalTexts):?>
                ...
            <?endif?>
            <? if($from < $totalTexts):?>
                <a style='margin-right:6px' href='/lenguaplus?from=<?=$from?><?foreach($qparams as $key=>$para):?><?if($key!='want' && $key!='from'&&!empty($para)):?>&<?=$key?>=<?=(is_array($para)?implode(',',$para):$para)?><?endif?><?endforeach?>' 
                   onclick='this.href+="&want="+$("#wantPagePer").val()'
                    id='backBtn'><?=$this->lang->es('Siguente')?></a>
            <?endif?>
            
            <span style='line-height:30px;'>
            <select style='width:55px' id="wantPagePer" >
                <?foreach(array('30','50','100','200','300') as $wt):?>
                    <option 
                        <? if ($want == $wt):?>selected='selected'<?endif?>
                        value='<?=$wt?>'><?=$wt?></option>
                <?endforeach;?>
            </select>                
            <?=$this->lang->en('of')?> <?=$totalTexts?>
            </span>
        <?else:?>    
            <?=$totalTexts?> <?=$this->lang->es('filas')?>
        <?endif?>    
    </caption>
    <thead>
        <tr>
            <? foreach ($headers as $key=>$head): ?>
                <th class="<?= $key ?> <?=($key == "langtracker_status") ? 'nosort' : '';?>"  >
                <?if ($key == "langtracker_es"):?>    
                <?= $this->lang->key($head);?> 
                <img src="/wwwroot/images/Colombia_16x16-32.png" />
                <?elseif ($key == "langtracker_en"):?>    
                <?= $this->lang->key($head);?> 
                <img src="/wwwroot/images/United-States_16x16-32.png" />
                <?elseif ($key == "langtracker_status"):?>    
                    <select style='width: 100%;margin: 0;float: left;' id="allStatusChanger" >
                    <option value=''><?=$this->lang->es('Cambiar todos campos')?></option>
                    <?foreach(array('debug','edited','live','deleted','propername') as $status):?>
                        <option value='<?=$status?>'><?=ucwords($this->lang->msg($status))?></option>
                    <?endforeach;?>
                    </select>
                <?else:?>
                <?= $this->lang->key($head);?> 
                <?endif;?>
                </th>
                
            <? endforeach; ?>
        </tr>
    </thead>    
    <tbody id="tableBody">
        <?$rowNum=0?>
        <? foreach ($texts as $text): ?>
            <tr class="<?=($rowNum&1) ? 'odd' : 'even'?> langRow" data-langid='<?=$text->langtracker_id?>' id='langtracker_<?=$text->langtracker_id?>' >
                <? foreach ($headers as $key=> $head): ?>
                        <td class="langtracker <?= $key ?>" >    
                        <?if ($key == "langtracker_status"):?>
                            <select name='statusChange' data-langid="<?=$text->langtracker_id?>" >
                                <?foreach(array('debug','edited','live','deleted','propername') as $status):?>
                                    <option <?if($text->$key == $status):?>selected='selected'<?endif;?> value='<?=$status?>'><?=ucwords($this->lang->msg($status))?></option>
                                <?endforeach;?>
                            </select>                                    
                            <button class="updateLang" title='<?=$this->lang->en('update')?> <?=(isset($text->count)) ? $text->count : ''?>' ><?=$this->lang->en('update')?> <?=(isset($text->count) && $text->count > 1) ? $text->count : ''?></button>
                        <?elseif ($key == "langtracker_key"):?>
                            <?= ellipse($text->$key, 30) ?>
                        <?elseif ($key == "langtracker_urls"):?>
                            <?php $urls = explode(',',$text->langtracker_urls); $dups = array(); ?>
                            <?foreach ($urls as $url):?>
                                <? if(!isset($dups[$url])):?>
                                    <a href="http://<?=$text->langtracker_host . $url?>" target="_blank"><?=$url?></a>
                                    <?php $dups[$url] = true; ?>
                                <?endif;?>
                            <?endforeach;?>                                    
                        <?elseif ($key == "langtracker_updated"):?>
                                    <?=$text->langtracker_updated?>
                        <?elseif ($key == "langtracker_es" || $key == "langtracker_en"):?>
                            <?php // if ($text->langtracker_type == 'ugc' && substr($key, strpos($key, "_")+1) == $text->langtracker_language):?>        
                                <textarea name="<?=substr($key, strpos($key, "_")+1).'_'.$text->langtracker_id?>" 
                                          data-langid="<?=$text->langtracker_id?>"
                                          data-language="<?=substr($key, strpos($key, "_")+1)?>"
                                          ><?=$text->$key?></textarea>
                        <?elseif ($key == "langtracker_file"):?>
                            <span title="<?=$text->$key?>"><?= ellipse(str_replace(ROOT_CD, '', $text->$key), -20)?></span>
                        <?else:?>
                            <?= (!isset($text->$key) || empty($text->$key)) ? "" : $text->$key ?>
                        <?endif;?>
                        </td>
                <? endforeach; ?>
            </tr>
        <? $rowNum++; endforeach; ?>
    </tbody>
</table>
</form>
