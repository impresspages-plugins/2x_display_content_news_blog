<div class="ipaStream">
    <label class="ipAdminLabel"><?php echo $this->escPar('standard/news_blog/admin_translations/stream') ?></label>
    <select name="stream" class="ipAdminSelect">
        <?php foreach ($streams as $key => $value) { ?>
        <option <?php echo (isset($stream) && $stream == $value['value']) ? 'selected="selected"' : '' ?> value="<?php echo $this->esc($value['value']) ?>"><?php echo $this->esc($value['title']) ?></option>
        <?php } ?>
    </select>
</div>
<div class="ipaTitleLevel">
    <label class="ipAdminLabel"><?php echo $this->escPar('standard/news_blog/admin_translations/title_level') ?></label>
    <select name="titleLevel" class="ipAdminSelect">
        <?php foreach ($levels as $key => $level) { ?>
        <option <?php echo ($titleLevel == $level['value']) ? 'selected="selected"' : '' ?> value="<?php echo $this->esc($level['value']) ?>"><?php echo $this->esc($level['title']) ?></option>
        <?php } ?>
    </select>
</div>
<div class="ipaShowReadMore">
    <label class="ipAdminLabel"><?php echo $this->escPar('standard/news_blog/admin_translations/show_read_more') ?></label>
    <input type="checkbox" name="showReadMore" class="ipAdminCheckbox" <?php echo isset($showReadMore) && (int)$showReadMore ? 'checked="checked"' : ''; ?>" />
</div>
<div class="ipaPagination">
    <label class="ipAdminLabel"><?php echo $this->escPar('standard/news_blog/admin_translations/pagination') ?></label>
    <input type="checkbox" name="pagination" class="ipAdminCheckbox" <?php echo isset($pagination) && (int)$pagination ? 'checked="checked"' : ''; ?>" />
</div>
<div class="ipaRecordsPerPage">
    <label class="ipAdminLabel"><?php echo $this->escPar('standard/news_blog/admin_translations/records_per_page') ?></label>
    <input name="recordsPerPage" class="ipAdminInput" value="<?php echo isset($recordsPerPage) ? $recordsPerPage : ''; ?>" type="number" />
</div>


