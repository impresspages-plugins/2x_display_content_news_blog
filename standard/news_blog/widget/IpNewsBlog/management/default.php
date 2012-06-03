<div class="ipaQuestion">
    <label class="ipAdminLabel"><?php echo $this->escPar('standard/news_blog/admin_translations/stream') ?></label>
    <select name="strem" class="ipAdminInput ipaStream">
        <?php foreach ($streams as $stream) { ?>
        <option value="<?php echo $this->esc($stream['value']) ?>"><?php echo $this->esc($stream['title']) ?></option>
        <?php } ?>
    </select>
</div>
<div class="ipaAnswer">
    <label class="ipAdminLabel"><?php echo $this->escPar('standard/news_blog/admin_translations/limit') ?></label>
    <input name="limit" class="ipAdminInput ipaLimit" value="<?php echo isset($limit) ? $limit : ''; ?>" type="number"/>
</div>
<div class="ipaAnswer">
    <label class="ipAdminLabel"><?php echo $this->escPar('standard/news_blog/admin_translations/pagination') ?></label>
    <input type="checkbox" name="pagination" class="ipAdminInput ipaPagination" <?php echo isset($pagination) && $pagination ? 'checked="checked"' : ''; ?>" />
</div>
