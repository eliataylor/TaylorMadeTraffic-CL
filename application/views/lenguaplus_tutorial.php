<div class="tutorial">
    <div style='margin-bottom: 20px;'>                
        <h2 class='clearer' style='margin:0; clear:both; float:left; width:100%'>
            <?php echo  $this->lang->en('LenguaPlus') ?>
            <span class="flags" style='float:right; margin:0'>
                <span style='font-size:12px'>(<?php echo $this->lang->en('Cambiar Idioma')?>)</span>
                <img <?if ($me['con']['lang'] != 'es'):?> style="opacity:.50; filter:alpha(opacity=50);"<?endif;?>
                    data-language="es" class="langBtn" src="/wwwroot/img/Colombia_24x24-32.png" />
                <img <?if ($me['con']['lang'] != 'en'):?> style="opacity:.50; filter:alpha(opacity=50);"<?endif;?>
                    data-language="en" class="langBtn" src="/wwwroot/img/United-States_24x24-32.png" />
            </span>
        </h2>
        <p><?php echo  ucfirst($this->lang->en('lenguaplus_desc'))?></p>            
    </div>
    <ul>
        <li>                
            <h3><?php echo  $this->lang->en('How To Change Text') ?>:</h3>
            <ul class='numList'>
                <li><a target='_blank' href='/lenguaplus/login'><?php echo  ucwords($this->lang->en('Login')) ?></a></li>
                <li><?php echo  ucwords($this->lang->en('Search by Key, URL, Type or Status')) ?></li>
                <li><?php echo  ucwords($this->lang->en('Write and preview your new text')) ?></li>                
                <li><?php echo  ucwords($this->lang->en('Click')) ?> <?php echo  $this->lang->en('publish') ?></li>
            </ul>                
        </li>        

        <li class='snapshots'>
            <img src='/wwwroot/img/tutorial/lenguaplus_es2.png' />            
        </li>
        <li>                
            <h3><?php echo  $this->lang->en('How To Use') ?>:</h3>
            <ul>
                <li><code>$this-&gt;lang-&gt;msg('some_key', [language])</code> || <code>$this-&gt;lang-&gt;line('some_key', [language])</code></li>
                <li><code>$this-&gt;lang-&gt;es('Texto en Espanol')</code></li>
                <li><code>$this-&gt;lang-&gt;en('Text in English')</code></li>                
                <li><code>$this-&gt;lang-&gt;ugc($user generated text)</code> :: <?php echo  $this->lang->en('ugc_use_instructions') ?></li>
            </ul>                
        </li>

        <li>
            <h3><?php echo  $this->lang->en('Required Files') ?></h3>
            <ul>
                <li>/application/core/Lang.php</li>
                <li>/application/config/lenguaplus.php</li>
                <li>/application/controllers/languapluscontroller.php</li>
                <li>/application/models/lenguaplus_Model.php</li>
                <li>/application/views/language_table.php</li>
                <li>/wwwroot/js/lenguaplus.js</li>
                <li>/wwwroot/css/lenguaplus.css</li>
            </ul>                                
            <h5><?php echo  $this->lang->en('Example Files') ?></h5>
            <ul>
                <li>/application/libraries/Thisvisitor.php</li>
                <li>/application/language/en/*,/application/language/es/*,/application/language/ugc/*</li>
            </ul>                                
        </li>
        <li>     
            <h3><?php echo  $this->lang->en('Configuration') ?></h3>
            <ul>
                <li><strong>LANGUAGES</strong>: <?php echo  $this->lang->en("Languages supported") ?> <?php echo  $this->lang->en('Default') ?>: array('es'=>'Espanol','en'=>'English')</li>
                <li><strong>USE_MSG_DATABASE</strong>: <?php echo  $this->lang->en('Whether to use translated text messages found in the database, as opposed to the static language files. This slows down performance since each key requires a query.') ?> <?php echo  $this->lang->en('Default') ?>: FALSE</li>
                <li><strong>USE_UGC_DATABASE</strong>: <?php echo  $this->lang->en('Whether to use translated user-generated-content stored in the database, as opposed to the static language files. This slows down performance since each key requires a query.') ?> <?php echo  $this->lang->en('Default') ?>: FALSE</li>
                <li><strong>TRACK_MSG_PRODUCTION</strong>: <?php echo  $this->lang->en('Whether to conditionally insert text messages from the system on production environments. This slows down performance since each key requires a query.') ?> <?php echo  $this->lang->en('Default') ?>: FALSE</li>
                <li><strong>TRACK_UGC_PRODUCTION</strong>: <?php echo  $this->lang->en('Whether to conditionally insert text messages from user-generated-content on production environments. This slows down performance since each key requires a query.') ?> <?php echo  $this->lang->en('Default') ?>: FALSE</li>
                <li><strong>status_2_watch</strong>: <?php echo  $this->lang->msg('lengua_status_options') ?> <?php echo  $this->lang->en('Default') ?>: 'live'</li>
                <li><strong>lang_2_track</strong>: <?php echo  $this->lang->msg('lang_2_track_instructions') ?> <?php echo  $this->lang->en('Default') ?>: 'es'</li>
                <li><strong>environment</strong>: <?php echo  $this->lang->en("Current environment: enum('production', 'development', 'testing') ") ?></li>
            </ul>                
        </li>

        <li>                
            <h3><?php echo  $this->lang->en('Installation') ?></h3>
            <ul>
                <li><?php echo  ucfirst($this->lang->en("Run")) ?> application/models/lenguaplus_schema.sql</li>
                <li><?php echo  ucfirst($this->lang->en("Copy the required files into your CodeIgniter project")) ?></li>
                <li><?php echo  ucfirst($this->lang->en("Adding your routing")) ?>: <code>$route['language(|.+?)'] = 'LenguaPlusController';</code></li>
                <li><?php echo  ucfirst($this->lang->en("Autoload")) ?>:
                    <ul>
                        <li><code>$autoload['libraries'] = array('database', 'session', 'Thisvisitor');</code></li>
                        <li><code>$autoload['helper'] = array('url', 'viewutils');</code></li>
                        <li><code>$autoload['model'] = array('LenguaPlus_model');</code></li>
                    </ul>
                </li>
                <li><?php echo  ucfirst($this->lang->en("In your main controller / library - ex. Thisvisitor.php - set your default language and load the file")) ?>: 
                    <ul>
                        <li><code>$CI->lang->setLang($this->visitor['con']['lang']);</code></li>
                        <li><code>$CI->lang->load('langplus_msg', $this->visitor['con']['lang']);</code></li>
                        <li><code>$me = array('con'=>'lang');</code></li>
                    </ul>
                </li>
                <li><?php echo  $this->lang->en("Go to") ?> <a target='_blank'  href='/lenguaplus'>/lenguaplus</a>
            </ul>                
        </li>

    </ul></div>