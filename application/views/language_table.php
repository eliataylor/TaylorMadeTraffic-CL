<div class="authorInfo">
    
<div class="flags">
    <img 
        <?if ($me['con']['lang'] != 'es'):?> style="opacity:.30; filter:alpha(opacity=30);"<?endif;?>
        data-language="es" class="langBtn" src="/wwwroot/images/Colombia_24x24-32.png" />
    <img 
        <?if ($me['con']['lang'] != 'en'):?> style="opacity:.30; filter:alpha(opacity=30);"<?endif;?>
        data-language="en" class="langBtn" src="/wwwroot/images/United-States_24x24-32.png" />
</div>
    
<p><?=$this->lang->en('Author')?>,</p>
<h1><?=$me['user_screenname']?></h1>
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
        </ul>
        <button id="publishBtn"><?=$this->lang->en('Publish')?></button>
        <button id="saveBtn"><?=$this->lang->en('Save')?></button>
        <li><?=count($texts)?> <?=$this->lang->en('rows')?></li>
</div>

<table class="tablesorter lang_table">
    <thead>
        <tr>
            <? foreach ($headers as $key=>$head): ?>
                <th class="<?= $key ?>"  >
                <?= $this->lang->key($head);?>
                <?if ($key == "langtracker_es"):?>    
                <img src="/wwwroot/images/Colombia_16x16-32.png" />
                <?elseif ($key == "langtracker_en"):?>    
                <img src="/wwwroot/images/United-States_16x16-32.png" />
                <?endif;?>
                </th>
            <? endforeach; ?>
        </tr>
    </thead>    
    <tbody id="tableBody">
        <? foreach ($texts as $text): ?>
            <tr class="langRow" data-langid='<?=$text->langtracker_id?>' id='langtracker_<?=$text->langtracker_id?>' >
                <? foreach ($headers as $key=> $head): ?>
                        <td class="langtracker <?= $key ?>" >    
                        <?if ($key == "count"):?>
                            <?= $text->count ?>
                        <?elseif ($key == "langtracker_status"):?>
                            <select name='statusChange' data-langid="<?=$text->langtracker_id?>" >
                                <?foreach(array('debug','edited','live','deleted','propername') as $status):?>
                                    <option <?if($text->$key == $status):?>selected='selected'<?endif;?> value='<?=$status?>'><?=ucwords($this->lang->msg($status))?></option>
                                <?endforeach;?>
                            </select>                                    
                            <button class="updateLang" title='<?=$this->lang->en('update')?>' ><?=$this->lang->en('update')?></button>
                        <?elseif ($key == "langtracker_key"):?>
                            <?= ellipse($text->$key, 50) ?>
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
        <? endforeach; ?>
    </tbody>
</table>
</form>