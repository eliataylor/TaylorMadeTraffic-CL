<div class='userProfile'>

    <?php $this->load->view('user_header'); ?>

    <?php if (!empty($uProfile['user_bio'])): ?>
        <div class='userBio'>
            <?php echo $this->lang->ugc($uProfile['user_bio']); ?>
            <div class="letterhead" style="height: 4px;margin-top: 4px;">
                <?php $this->load->view('letterhead', ['variant' => 'header', "style" => "opacity:1;"]); ?>
            </div>
        </div>
    <?php endif ?>

</div>
